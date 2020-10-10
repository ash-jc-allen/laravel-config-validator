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
}