<?php

namespace AshAllenDesign\ConfigValidator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void run()
 * @method static ConfigValidator throwExceptionOnFailure()
 * @method static array<string,string[]> errors()
 *
 * @see \AshAllenDesign\ConfigValidator\Services\ConfigValidator
 */
class ConfigValidator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'config-validator';
    }
}
