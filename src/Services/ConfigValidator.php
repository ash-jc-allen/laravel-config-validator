<?php

namespace AshAllenDesign\ConfigValidator\Services;

use AshAllenDesign\ConfigValidator\Exceptions\DirectoryNotFoundException;
use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Exceptions\NoValidationFilesFoundException;
use AshAllenDesign\ConfigValidator\Traits\LoadsConfigValidationFiles;
use Illuminate\Support\Facades\Validator;

class ConfigValidator
{
    use LoadsConfigValidationFiles;

    /**
     * The repository that holds the config values being
     * validated, along with the rules and messages
     * used for running the validation.
     *
     * @var ValidationRepository
     */
    private $validationRepository;

    /**
     * An array of the validation error messages.
     *
     * @var array
     */
    private $errors = [];

    /**
     * ConfigValidator constructor.
     *
     * @param  ValidationRepository|null  $validationRepository
     */
    public function __construct(ValidationRepository $validationRepository = null)
    {
        $this->validationRepository = $validationRepository ?? new ValidationRepository();
    }

    /**
     * Return the validation error messages.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Handle the loading of the config validation files
     * and then validate the config.
     *
     * @param  array  $configFiles
     * @param  string|null  $validationFolderPath
     * @return bool
     * @throws InvalidConfigValueException
     * @throws DirectoryNotFoundException
     * @throws NoValidationFilesFoundException
     */
    public function run(array $configFiles = [], string $validationFolderPath = null): bool
    {
        $validationFiles = $this->getValidationFiles($configFiles, $validationFolderPath);

        foreach ($validationFiles as $key => $path) {
            $ruleSet = require $path;

            $this->validationRepository->push($key, $ruleSet);
        }

        return $this->runValidator();
    }

    /**
     * Validate the config values against the config rules
     * that have been set.
     *
     * @return bool
     * @throws InvalidConfigValueException
     */
    private function runValidator(): bool
    {
        $ruleSet = $this->validationRepository->asArray();

        $validator = Validator::make($ruleSet['config_values'], $ruleSet['rules'], $ruleSet['messages']);

        if ($validator->fails()) {
            $this->errors = $validator->errors()->messages();

            throw new InvalidConfigValueException($validator->errors()->first());
        }

        return true;
    }
}
