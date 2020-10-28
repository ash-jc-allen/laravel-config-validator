<?php

namespace AshAllenDesign\ConfigValidator\Console\Commands;

use AshAllenDesign\ConfigValidator\Exceptions\DirectoryNotFoundException;
use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Exceptions\NoValidationFilesFoundException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\TableSeparator;

class ValidateConfigCommand extends Command
{
    const ERROR_TABLE_HEADERS = [
        'Config Field',
        'Config Value',
        'Error'
    ];

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
     * The object that is used for validating the config.
     *
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
     * @throws DirectoryNotFoundException
     * @throws InvalidConfigValueException
     * @throws NoValidationFilesFoundException
     */
    public function handle(): int
    {
        $this->info('Validating config...');

        $this->configValidator
            ->throwExceptionOnFailure(false)
            ->run($this->determineFilesToValidate(), $this->option('path'));

        if (! empty($this->configValidator->errors())) {
            $this->buildErrorOutput();

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

    /**
     * Build up the console output to show the errors. We
     * output the errors in a table.
     */
    private function buildErrorOutput(): void
    {
        $rows = [];

        foreach ($this->configValidator->errors() as $configField => $errors) {
            foreach ($errors as $error) {
                $rows[] = [
                    $configField,
                    config($configField),
                    $error,
                ];
            }

            if ($configField !== array_key_last($this->configValidator->errors())) {
                array_push($rows, [new TableSeparator(['colspan' => 3])]);
            }
        }

        $this->error('Config validation failed!');
        $this->table(self::ERROR_TABLE_HEADERS, $rows);
    }
}
