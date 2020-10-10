<?php

namespace AshAllenDesign\ConfigValidator\App\Services;

use AshAllenDesign\ConfigValidator\App\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\App\Traits\LoadsConfigValidationFiles;
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
     * ConfigValidator constructor.
     *
     * @param  ValidationRepository|null  $validationRepository
     */
    public function __construct(ValidationRepository $validationRepository = null)
    {
        $this->validationRepository = $validationRepository ?? new ValidationRepository();
    }

    /**
     * Handle the loading of the config validation files
     * and then validate the config.
     *
     * @param  string|null  $validationFolderPath
     * @throws InvalidConfigValueException
     */
    public function run(string $validationFolderPath = null): void
    {
        $validationFiles = $this->getValidationFiles($validationFolderPath);

        foreach ($validationFiles as $key => $path) {
            $ruleSet = require $path;

            $this->validationRepository->push($key, $ruleSet);
        }

        $this->runValidator();
    }

    /**
     * Validate the config values against the config rules
     * that have been set.
     *
     * @throws InvalidConfigValueException
     */
    private function runValidator(): void
    {
        $ruleSet = $this->validationRepository->asArray();

        $validator = Validator::make($ruleSet['config_values'], $ruleSet['rules'], $ruleSet['messages']);

        if ($validator->fails()) {
            throw new InvalidConfigValueException($validator->errors()->first());
        }
    }
}
