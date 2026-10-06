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
     */
    public function register(): void
    {
        $this->app->alias(ConfigValidator::class, 'config-validator');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register tags only so provider-wide publishing cannot combine the rulesets.
        foreach ([11, 12, 13] as $version) {
            $this->addPublishGroup(
                group: 'config-validator-defaults-laravel-'.$version,
                paths: [
                    __DIR__.'/../../stubs/config-validation/laravel-'.$version => base_path('config-validation'),
                ],
            );
        }

        if ($this->app->runningInConsole()) {
            $this->loadViewsFrom(__DIR__.'/../../resources/views', 'config-validator');

            $this->commands([
                ValidateConfigCommand::class,
                ValidationMakeCommand::class,
            ]);
        }
    }
}
