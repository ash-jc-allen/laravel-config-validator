<?php

namespace AshAllenDesign\ConfigValidator\Console\Commands;

use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ValidateConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:validate
                            {--files=* : The config files that should be validated.}
                            {--path= : The path of the folder where the validation files are location.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate the application config.';

    /**
     * @var ConfigValidator
     */
    private $configValidator;

    /**
     * Create a new command instance.
     *
     * @param  ConfigValidator  $configValidator
     */
    public function __construct(ConfigValidator $configValidator)
    {
        parent::__construct();

        $this->configValidator = $configValidator;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Validating config...');

        try {
            $this->configValidator->run($this->determineFilesToValidate(), $this->option('path'));
        } catch (InvalidConfigValueException $exception) {
            $this->error('Config validation failed!');
            $this->error($exception->getMessage());

            return 1;
        }

        $this->info('Config validation passed!');

        return 0;
    }

    /**
     * Determine the config files that should be validated.
     * We do this by mapping any comma-separated 'files'
     * inputs to an array of strings that can be
     * passed to the ConfigValidator object.
     *
     * @return array
     */
    private function determineFilesToValidate(): array
    {
        $filesToValidate = [];

        foreach ($this->option('files') as $fileOption) {
            if (Str::contains($fileOption, ',')) {
                $exploded = explode(',', $fileOption);

                $filesToValidate = array_merge($filesToValidate, $exploded);

                continue;
            }

            $filesToValidate = array_merge($filesToValidate, [$fileOption]);
        }

        return $filesToValidate;
    }
}
