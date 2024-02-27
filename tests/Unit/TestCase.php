<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit;

use AshAllenDesign\ConfigValidator\Facades\ConfigValidator;
use AshAllenDesign\ConfigValidator\Providers\ConfigValidatorProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ConfigValidatorProvider::class];
    }

    /**
     * Load package alias.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'config-validator' => ConfigValidator::class,
        ];
    }
}
