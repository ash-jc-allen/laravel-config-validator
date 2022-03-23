<?php

namespace AshAllenDesign\ConfigValidator\Providers;

use AshAllenDesign\ConfigValidator\Console\Commands\ValidateConfigCommand;
use AshAllenDesign\ConfigValidator\Console\Commands\ValidationMakeCommand;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Illuminate\Support\ServiceProvider;

class ConfigValidatorProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->alias(ConfigValidator::class, 'config-validator');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish the default config validation rules.
        $this->publishes([
            __DIR__.'/../../stubs/config-validation' => base_path('config-validation'),
        ], 'config-validator-defaults');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ValidateConfigCommand::class,
                ValidationMakeCommand::class,
            ]);
        }
    }
}
