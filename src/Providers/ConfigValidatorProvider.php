<?php

namespace AshAllenDesign\ConfigValidator\Providers;

use AshAllenDesign\ConfigValidator\Console\Commands\ValidateConfigCommand;
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                ValidateConfigCommand::class,
            ]);
        }
    }
}
