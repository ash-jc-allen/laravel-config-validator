<?php

namespace AshAllenDesign\ConfigValidator\Services;

use Closure;

class Rule
{
    public const ENV_PRODUCTION = 'production';

    public const ENV_LOCAL = 'local';

    public const ENV_TESTING = 'testing';

    /**
     * The config field name being validated.
     *
     * @var string
     */
    private string $fieldName;

    /**
     * The validation used for validating the config field.
     *
     * @var array<string|\Illuminate\Contracts\Validation\ValidationRule|\Illuminate\Validation\Rule|Closure>
     */
    private array $rules = [];

    /**
     * The custom messages being used when validating the
     * config field.
     *
     * @var array<string,string>
     */
    private array $messages = [];

    /**
     * @var string[]
     */
    private array $environments = [];

    /**
     * Rule constructor.
     *
     * @param  string  $fieldName
     */
    public function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    /**
     * A helper method used for creating a new rule.
     *
     * @param  string  $fieldName
     * @return Rule
     */
    public static function make(string $fieldName): Rule
    {
        return new self($fieldName);
    }

    /**
     * Set the rules used for validating the config.
     *
     * @param  array<string|\Illuminate\Contracts\Validation\ValidationRule|\Illuminate\Validation\Rule|Closure>  $rules
     * @return $this
     */
    public function rules(array $rules): self
    {
        $this->rules = array_merge($this->rules, $rules);

        return $this;
    }

    /**
     * Set the custom messages used when validating the
     * config.
     *
     * @param  array<string,string>  $messages
     * @return $this
     */
    public function messages(array $messages): self
    {
        $this->messages = array_merge($this->messages, $messages);

        return $this;
    }

    /**
     * @param  string[]  $environments
     */
    public function environments(array $environments): self
    {
        $this->environments = array_merge($this->environments, $environments);

        return $this;
    }

    /**
     * Get the config field name that this rule relates to.
     *
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * Get the validation rules set within this rule.
     *
     * @return array<string|\Illuminate\Contracts\Validation\ValidationRule|\Illuminate\Validation\Rule|Closure>
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Get the validation messages set within this rule.
     *
     * @return array<string,string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Get the app environments set within this rule.
     *
     * @return string[]
     */
    public function getEnvironments(): array
    {
        return $this->environments;
    }
}
