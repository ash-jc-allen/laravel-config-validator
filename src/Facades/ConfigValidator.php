<?php

namespace AshAllenDesign\ConfigValidator\Facades;

use Illuminate\Support\Facades\Facade;
use RuntimeException;

/**
 * @method static void run()
 *
 * @see \AshAllenDesign\ConfigValidator\Services\ConfigValidator
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
