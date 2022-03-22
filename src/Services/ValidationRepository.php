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
    private array $configValues = [];

    /**
     * An array of rules that are to be used for validating
     * the config values.
     *
     * @var array
     */
    private array $rules = [];

    /**
     * An array of custom messages that are to be used when
     * validating the config values.
     *
     * @var array
     */
    private array $messages = [];

    /**
     * Add the new Rules' data to the repository so that we
     * can read the data later when validating. When doing
     * this, we check that the rule is supposed to run in
     * this environment. Any rules set to run in other
     * environments won't be stored and will just be
     * skipped.
     *
     * @param  string  $key
     * @param  Rule[]  $rules
     */
    public function push(string $key, array $rules): void
    {
        foreach ($rules as $field => $rule) {
            if (! $this->shouldValidateUsingThisRule($rule)) {
                continue;
            }

            $configKey = $key.'.'.$rule->getFieldName();

            // Add the rules for the field to the repository.
            $this->rules[$configKey] = $rule->getRules();

            // Add the current config values for the field to the repository.
            $this->fetchCurrentConfigValues($key, $rule);

            // Add any custom messages for the field to the repository.
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

    /**
     * Determine whether if we should be storing the rule
     * to use for validation. We do this by checking if
     * an environment has been explicitly defined on
     * the rule. If it hasn't, we can add the rule.
     * If it has, we can only add the rule if the
     * environment matches.
     *
     * @param  Rule  $rule
     * @return bool
     */
    private function shouldValidateUsingThisRule(Rule $rule): bool
    {
        $environments = $rule->getEnvironments();

        if (empty($environments)) {
            return true;
        }

        return in_array(app()->environment(), $environments, true);
    }

    /**
     * This takes a config field and hydrates it into a
     * nested array that we can validate against. For
     * example, we can use it convert the config
     * item 'mail.from.address' that is equal
     * to 'example@domain.com' to this...
     *
     * [
     *     'mail' => [
     *         'from' => [
     *             'address' => 'example@domain.com'
     *         ]
     *     ]
     * ]
     *
     * @param  string  $configKey
     * @param  Rule  $rule
     * @return array
     */
    private function hydrateConfigValueArray(string $configKey, Rule $rule): array
    {
        $keys = explode('.', $rule->getFieldName());
        $value = config($configKey.'.'.$rule->getFieldName());

        while ($key = array_pop($keys)) {
            $value = [$key => $value];
        }

        return $value;
    }

    /**
     * Fetch the current config values that are set in the
     * system and then add them to the repository for
     * validating.
     *
     * @param  string  $key
     * @param  Rule  $rule
     */
    private function fetchCurrentConfigValues(string $key, Rule $rule): void
    {
        $hydrated = $this->hydrateConfigValueArray($key, $rule);
        $field = array_keys($hydrated)[0];

        if (empty($this->configValues[$key][$field])) {
            $this->configValues[$key][$field] = [];
        }

        // If the config value is nested (e.g. mail.from.address) then we add
        // it differently to standard non-nested fields.
        if (is_array($hydrated[$field])) {
            $this->configValues[$key][$field] += $hydrated[$field];
        } else {
            $this->configValues[$key][array_key_first($hydrated)] = $hydrated[array_key_first($hydrated)];
        }
    }
}
