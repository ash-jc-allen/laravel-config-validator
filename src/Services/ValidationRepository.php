<?php

namespace AshAllenDesign\ConfigValidator\Services;

class ValidationRepository
{
    /**
     * An array of the config values that are being
     * validated.
     *
     * @var array
     */
    private $configValues = [];

    /**
     * An array of rules that are to be used for validating
     * the config values.
     *
     * @var array
     */
    private $rules = [];

    /**
     * An array of custom messages that are to be used when
     * validating the config values.
     *
     * @var array
     */
    private $messages = [];

    /**
     * Add the new Rules' data to the repository so that we
     * can read the data later when validating.
     *
     * @param  string  $key
     * @param  Rule[]  $rules
     */
    public function push(string $key, array $rules): void
    {
        foreach ($rules as $field => $rule) {
            $configKey = $key.'.'.$rule->getFieldName();

            $this->rules[$configKey] = implode('|', $rule->getRules());
            $this->configValues[$key][$rule->getFieldName()] = config($configKey);

            foreach ($rule->getMessages() as $messageField => $message) {
                $this->messages[$configKey.'.'.$messageField] = $message;
            }
        }
    }

    /**
     * Return the class' rules, config values and messages
     * as an array.
     *
     * @return array
     */
    public function asArray(): array
    {
        return [
            'rules'         => $this->rules,
            'messages'      => $this->messages,
            'config_values' => $this->configValues,
        ];
    }
}
