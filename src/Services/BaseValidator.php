<?php

namespace AshAllenDesign\ConfigValidator\Services;

use AshAllenDesign\ConfigValidator\Traits\LoadsConfigValidationFiles;

abstract class BaseValidator
{
    use LoadsConfigValidationFiles;

    /**
     * The repository that holds the config values being
     * validated, along with the rules and messages
     * used for running the validation.
     *
     * @var ValidationRepository
     */
    protected ValidationRepository $validationRepository;

    /**
     * An array of the validation error messages.
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * ConfigValidator constructor.
     *
     * @param ValidationRepository|null $validationRepository
     */
    public function __construct(ValidationRepository $validationRepository = null)
    {
        $this->validationRepository = $validationRepository ?? new ValidationRepository();
    }

    abstract public function run(array $configFiles = [], string $validationFolderPath = null): bool;

    /**
     * Return the validation error messages.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
