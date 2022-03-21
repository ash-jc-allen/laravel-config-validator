<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Stubs;

use Illuminate\Contracts\Validation\Rule;

class IsFooBar implements Rule
{
    public function passes($attribute, $value)
    {
        return $value === 'foobar';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be equal to foobar.';
    }
}
