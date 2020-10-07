<?php

namespace AshAllenDesign\ConfigValidator\App\Services;

class Rule
{
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var array
     */
    private $rules = [];

    public function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    public static function make(string $fieldName)
    {
        return new static($fieldName);
    }

    public function rules(array $rules)
    {
        $this->rules = array_merge($this->rules, $rules);

        return $this;
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}
