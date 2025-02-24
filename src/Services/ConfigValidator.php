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
    private ValidationRepository $validationRepository;

    /**
     * An array of the validation error messages.
     *
     * @var array<string,string[]>
     */
    private array $errors = [];

    /**
     * Specifies whether if an exception should be thrown
     * if the config validation fails.
     *
     * @var bool
     */
    private bool $throwExceptionOnFailure = true;

    /**
     * ConfigValidator constructor.
     *
     * @param  ValidationRepository|null  $validationRepository
     */
    public function __construct(?ValidationRepository $validationRepository = null)
    {
        $this->validationRepository = $validationRepository ?? new ValidationRepository();
    }

    /**
     * Return the validation error messages.
     *
     * @return array<string,string[]>
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Determine whether an exception should be thrown if
     * the validation fails.
     *
     * @param  bool  $throwException
     * @return ConfigValidator
     */
    public function throwExceptionOnFailure(bool $throwException = true): self
    {
        $this->throwExceptionOnFailure = $throwException;

        return $this;
    }

    /**
     * Handle the loading of the config validation files
     * and then validate the config.
     *
     * @param  string[]  $configFiles
     * @param  string|null  $validationFolderPath
     * @return bool
     *
     * @throws InvalidConfigValueException
     * @throws DirectoryNotFoundException
     * @throws NoValidationFilesFoundException
     */
    public function run(array $configFiles = [], ?string $validationFolderPath = null): bool
    {
        $validationFiles = $this->getValidationFiles($configFiles, $validationFolderPath);

        foreach ($validationFiles as $key => $path) {
            $ruleSet = require $path;

            $this->validationRepository->push($key, $ruleSet);
        }

        return $this->runValidator();
    }

    /**
     * Validate config values  with rules that are passed in inline rather
     * than being read from a file in the filesystem.
     *
     * @param  array<string,array<Rule>>  $ruleGroups
     *
     * @throws InvalidConfigValueException
     */
    public function runInline(array $ruleGroups): bool
    {
        foreach ($ruleGroups as $configKey => $rules) {
            $this->validationRepository->push($configKey, $rules);
        }

        return $this->runValidator();
    }

    /**
     * Validate the config values against the config rules
     * that have been set. If throwExceptionOnFailure is
     * set to true, the validator's first error message
     * will be used as the message in the thrown
     * exception.
     *
     * @return bool
     *
     * @throws InvalidConfigValueException
     */
    private function runValidator(): bool
    {
        $ruleSet = $this->validationRepository->asArray();

        // Build an associative array of the keys that we are validating. We
        // can pass this to the validator so that the config key names
        // are preserved in the error messages and not changed.
        $attributes = array_combine(
            array_keys($ruleSet['rules']),
            array_keys($ruleSet['rules']),
        );

        $validator = Validator::make(
            $ruleSet['config_values'],
            $ruleSet['rules'],
            $ruleSet['messages'],
            $attributes,
        );

        if ($validator->fails()) {
            $this->errors = $validator->errors()->messages();

            if ($this->throwExceptionOnFailure) {
                throw new InvalidConfigValueException($validator->errors()->first());
            }

            return false;
        }

        return true;
    }
}
