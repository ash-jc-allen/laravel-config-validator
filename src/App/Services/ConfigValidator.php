<?php

namespace AshAllenDesign\ConfigValidator\App\Services;

use AshAllenDesign\ConfigValidator\App\Exceptions\InvalidConfigValueException;
use Illuminate\Support\Facades\Validator;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ConfigValidator
{
    /**
     * @var ValidationRepository
     */
    private $validationRepository;

    /**
     * ConfigValidator constructor.
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
     * @throws InvalidConfigValueException
     */
    public function run(): void
    {
        $validationFiles = $this->getValidationFiles();

        foreach ($validationFiles as $key => $path) {
            $ruleSet = require $path;

            $this->validationRepository->push($key, $ruleSet);
        }

        $this->runValidator();
    }

    /**
     * Get all of the configuration validation files that
     * are set.
     *
     * @return array
     */
    private function getValidationFiles(): array
    {
        $files = [];

        $configPath = realpath(app()->configPath('validation'));

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  SplFileInfo  $file
     * @param  string  $configPath
     * @return string
     */
    protected function getNestedDirectory(SplFileInfo $file, string $configPath): string
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }

        return $nested;
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
