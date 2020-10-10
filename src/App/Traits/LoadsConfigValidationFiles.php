<?php

namespace AshAllenDesign\ConfigValidator\App\Traits;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

trait LoadsConfigValidationFiles
{
    /**
     * Get all of the configuration validation files that
     * are set.
     *
     * @param  string|null  $validationFolderPath
     * @return array
     */
    private function getValidationFiles(string $validationFolderPath = null): array
    {
        $files = [];

        $folderPath = $this->determineFolderPath($validationFolderPath);

        foreach (Finder::create()->files()->name('*.php')->in($folderPath) as $file) {
            $directory = $this->getNestedDirectory($file, $folderPath);

            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * If a custom validation folder path has been set then
     * get the full path. Otherwise, return the default
     * path in the config/validation folder.
     *
     * @param  string|null  $validationFolderPath
     * @return string
     */
    protected function determineFolderPath(string $validationFolderPath = null): string
    {
        if ($validationFolderPath) {
            return realpath(app()->basePath($validationFolderPath));
        }

        return realpath(app()->configPath('validation'));
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
}
