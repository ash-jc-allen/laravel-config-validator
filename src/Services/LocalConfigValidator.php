<?php

namespace AshAllenDesign\ConfigValidator\Services;

use Illuminate\Support\Arr;

class LocalConfigValidator extends BaseValidator
{
    public function run(array $configFiles = [], string $validationFolderPath = null): bool
    {
        $localKeys = $this->getCleanLocalConfigKeys();

        $ruleKeys = $this->validationArray();

        // get the local keys that are not defined in the rules.
        $missing = array_diff($localKeys, $ruleKeys);

        foreach ($missing as $value) {
            $this->errors[$value][] = 'No validation rule specified';
        }

        if (! empty($this->errors)) {
            return false;
        }

        return true;
    }

    private function getCleanLocalConfigKeys(): array
    {
        $localKeys = $this->getAllLocalConfigKeys();

        return $this->removeKeysEndingOnIntegers($localKeys);
    }

    private function getAllLocalConfigKeys(): array
    {
        $localConfigFiles = $this->getValidationFiles([], '/config');

        $allLocalConfigs = [];
        foreach ($localConfigFiles as $key => $path) {
            $localConfig = require $path;

            $allLocalConfigs[$key] = $localConfig;
        }

        return array_keys(Arr::dot($allLocalConfigs));
    }

    private function removeKeysEndingOnIntegers(array $rawKeys): array
    {
        foreach ($rawKeys as $key => $value) {
            $rawKeys = $this->convertNumericEnding($value, $rawKeys, $key);
        }

        return $rawKeys;
    }

    private function convertNumericEnding(string $key, array $rawKeys, int $index): array
    {
        $processedKeys = $rawKeys;

        $explodedKey = explode('.', $key);
        $lastElementInKey = end($explodedKey);

        if (is_numeric($lastElementInKey)) {
            unset($processedKeys[$index]);      // removes : config.value.0 ; config.value.1

            // restore the array element
            array_pop($explodedKey);
            if (0 === (int) $lastElementInKey) {
                $processedKeys[] = implode('.', $explodedKey);      // adds: config.value
            }
        }

        return $processedKeys;
    }

    public function validationArray(array $configFiles = [], string $validationFolderPath = null)
    {
        $validationFiles = $this->getValidationFiles($configFiles, $validationFolderPath);

        foreach ($validationFiles as $key => $path) {
            $ruleSet = require $path;

            $this->validationRepository->push($key, $ruleSet);
        }

        return array_keys($this->validationRepository->asArray()['rules']);
    }
}
