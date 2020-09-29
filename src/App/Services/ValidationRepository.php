<?php

namespace AshAllenDesign\ConfigValidator\App\Services;

class ValidationRepository
{
    private $configValues = [];

    private $rules = [];

    /**
     * @param  string  $key
     * @param  Rule[]  $rules
     */
    public function push(string $key, array $rules)
    {
        foreach ($rules as $field => $rule) {
            $configKey = $key.'.'.$rule->getFieldName();

            $this->rules[$configKey] = implode('|', $rule->getRules());
            $this->configValues[$key][$rule->getFieldName()] = config($configKey);

//            $this->rules[$configKey] = [
//                'key' => $configKey,
//                'value' => config($configKey),
//                'rules' => implode('|', $rule->getRules())
//            ];
        }
    }

    public function asArray(): array
    {
        return [
            'rules'         => $this->rules,
            'config_values' => $this->configValues
        ];
    }
}