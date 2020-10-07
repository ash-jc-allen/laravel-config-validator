<?php

namespace AshAllenDesign\ConfigValidator\App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void run()
 *
 * @see \AshAllenDesign\ConfigValidator\App\Services\ConfigValidator
 */
class ConfigValidator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return 'config-validator';
    }
}
