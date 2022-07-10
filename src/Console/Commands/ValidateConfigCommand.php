<?php

namespace AshAllenDesign\ConfigValidator\Console\Commands;

use AshAllenDesign\ConfigValidator\Exceptions\DirectoryNotFoundException;
use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Exceptions\NoValidationFilesFoundException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use AshAllenDesign\ConfigValidator\Services\LocalConfigValidator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use function Termwind\render;

class ValidateConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:validate
                            {--files=* : The config files that should be validated.}
                            {--path= : The path of the folder where the validation files are location.}
                            {--skip-missing : Skip configs that are not validated.}';

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
     * The object that is used for validating the local config.
     *
     * @var LocalConfigValidator
     */
    private LocalConfigValidator $configLocalValidator;

    /**
     * Create a new command instance.
     *
     * @param  ConfigValidator  $configValidator
     */
    public function __construct(ConfigValidator $configValidator, LocalConfigValidator $configLocalValidator)
    {
        parent::__construct();

        $this->configValidator = $configValidator;
        $this->configLocalValidator = $configLocalValidator;
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
        if (!$this->option('skip-missing')) {
            $this->configLocalValidator->run();
        }


        try {
            $this->configValidator
                ->throwExceptionOnFailure(false)
                ->run($this->determineFilesToValidate(), $this->option('path'));
        } catch (DirectoryNotFoundException|NoValidationFilesFoundException $exception) {
            $this->displayErrorMessage($exception->getMessage());

            return self::FAILURE;
        }

        if (! empty($this->configValidator->errors()) || $this->configLocalValidator->errors()) {
            render(view('config-validator::validate-config', [
                'allErrors' => $this->configValidator->errors(),
                'allMissing' => $this->configLocalValidator->errors(),
            ]));

            return self::FAILURE;
        }

        $this->displaySuccessfulValidationMessage();

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

    private function displaySuccessfulValidationMessage(): void
    {
        render(<<<'HTML'
            <div class="my-1 mx-2 bg-green text-black px-1 font-bold">
                Config validation passed!
            </div>
        HTML);
    }

    private function displayErrorMessage(string $message): void
    {
        render(<<<HTML
                <div class="my-1 mx-2 bg-red-700 text-white font-bold px-1 mb-1">$message</div>
            HTML);
    }
}
