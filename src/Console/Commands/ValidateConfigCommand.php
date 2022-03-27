<?php

namespace AshAllenDesign\ConfigValidator\Console\Commands;

use AshAllenDesign\ConfigValidator\Exceptions\DirectoryNotFoundException;
use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Exceptions\NoValidationFilesFoundException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\ConsoleOutput;
use function Termwind\{render, renderUsing};

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
     * The object that is used for validating the config.
     *
     * @var ConfigValidator
     */
    private ConfigValidator $configValidator;

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
     *
     * @throws DirectoryNotFoundException
     * @throws InvalidConfigValueException
     * @throws NoValidationFilesFoundException
     */
    public function handle(): int
    {
        $output = (new ConsoleOutput)->section();

        if ($this->laravel->environment() !== 'testing') {
            renderUsing($output);
        }

        render(<<<HTML
            <div class="my-1 mx-2">
                Validating config...
            </div>
        HTML);

        $this->configValidator
            ->throwExceptionOnFailure(false)
            ->run($this->determineFilesToValidate(), $this->option('path'));

        $output->clear();

        if (! empty($this->configValidator->errors())) {
            render(view('config-validator::validate-config', [
                'allErrors' => $this->configValidator->errors(),
            ]));

            return self::FAILURE;
        }

        render(<<<HTML
            <div class="my-1 mx-2 bg-green text-black px-1 font-bold">
                Config validation passed!
            </div>
        HTML);

        return self::SUCCESS;
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
