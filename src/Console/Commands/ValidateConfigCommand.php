<?php

namespace AshAllenDesign\ConfigValidator\Console\Commands;

use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Illuminate\Console\Command;

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
            $this->configValidator->run($this->option('files'), $this->option('path'));
        } catch (InvalidConfigValueException $exception) {
            $this->error('Config validation failed!');
            $this->error($exception->getMessage());

            return 1;
        }

        $this->info('Config validation passed!');

        return 0;
    }
}
