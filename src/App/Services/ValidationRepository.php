<?php

namespace AshAllenDesign\ConfigValidator\App\Services;

class ValidationRepository
{
    private $configValues = [];

    private $rules = [];

    private $messages = [];

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

            foreach($rule->getMessages() as $messageField => $message) {
                $this->messages[$configKey.'.'.$messageField] = $message;
            }
        }
    }

    public function asArray(): array
    {
        return [
            'rules'         => $this->rules,
            'messages'      => $this->messages,
            'config_values' => $this->configValues,
        ];
    }
}
