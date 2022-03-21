<?php

namespace AshAllenDesign\ConfigValidator\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ValidationMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:config-validation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new config validation file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Config validation';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/config-validation.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        return $this->laravel->basePath()
               .'/config-validation/'
               .str_replace('\\', '/', $this->argument('name')).'.php';
    }
}
