<?php

namespace AshAllenDesign\ConfigValidator\Services;

use Closure;
use Illuminate\Support\Arr;

class ValidationRepository
{
    /**
     * An array of the config values that are being
     * validated.
     *
     * @var array<string,mixed>
     */
    private array $configValues = [];

    /**
     * An array of rules that are to be used for validating
     * the config values.
     *
     * @var array<string,array<string|\Illuminate\Contracts\Validation\ValidationRule|\Illuminate\Validation\Rule|Closure>>
     */
    private array $rules = [];

    /**
     * An array of custom messages that are to be used when
     * validating the config values.
     *
     * @var array<string,string>
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
     * @return array<string,mixed>
     */
    public function asArray(): array
    {
        return [
            'rules' => $this->rules,
            'messages' => $this->messages,
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
     * Fetch the current config values that are set in the
     * system and then add them to the repository for
     * validating.
     *
     * @param  string  $key
     * @param  Rule  $rule
     */
    private function fetchCurrentConfigValues(string $key, Rule $rule): void
    {
        Arr::set(
            array: $this->configValues[$key],
            key: $rule->getFieldName(),
            value: config($key.'.'.$rule->getFieldName()),
        );
    }
}
