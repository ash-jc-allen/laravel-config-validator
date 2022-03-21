<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Services\ConfigValidator;

use AshAllenDesign\ConfigValidator\Exceptions\DirectoryNotFoundException;
use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Exceptions\NoValidationFilesFoundException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use AshAllenDesign\ConfigValidator\Tests\Unit\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class RunTest extends TestCase
{
    /** @test */
    public function validator_can_be_run_in_default_location_and_all_files()
    {
        // Set valid config values that will pass all of the validation rules.
        Config::set('mail.from.address', 'mail@ashallendesign.co.uk');
        Config::set('mail.from.to', 'Ashley Allen');
        Config::set('mail.host', 'a random string');
        Config::set('mail.port', 1234);
        Config::set('cache.prefix', 'foobar');

        $mailStubFilePath = __DIR__.'/../../Stubs/mail.php';
        $cacheStubFilePath = __DIR__.'/../../Stubs/cache.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/mail.php'), file_get_contents($mailStubFilePath));
        File::put(base_path('config-validation/cache.php'), file_get_contents($cacheStubFilePath));

        $configValidator = new ConfigValidator();
        $this->assertTrue($configValidator->run());
    }

    /** @test */
    public function validator_can_be_run_in_a_custom_location()
    {
        // Set valid config values that will pass all of the validation rules.
        Config::set('mail.from.address', 'mail@ashallendesign.co.uk');
        Config::set('mail.from.to', 'Ashley Allen');
        Config::set('mail.host', 'a random string');
        Config::set('mail.port', 1234);
        Config::set('cache.prefix', 'foobar');

        $mailStubFilePath = __DIR__.'/../../Stubs/mail.php';
        $cacheStubFilePath = __DIR__.'/../../Stubs/cache.php';

        File::deleteDirectory(base_path('custom-validation'));

        File::makeDirectory(base_path('custom-validation'));
        File::put(base_path('custom-validation/mail.php'), file_get_contents($mailStubFilePath));
        File::put(base_path('custom-validation/cache.php'), file_get_contents($cacheStubFilePath));

        $configValidator = new ConfigValidator();
        $this->assertTrue($configValidator->run([], 'custom-validation'));
    }

    /** @test */
    public function validator_can_be_run_with_custom_files()
    {
        // Set valid config values that will pass all of the validation rules.
        Config::set('mail.from.address', 'mail@ashallendesign.co.uk');
        Config::set('mail.from.to', 'Ashley Allen');
        Config::set('mail.host', 'a random string');
        Config::set('mail.port', 1234);
        Config::set('cache.prefix', 'foobar');

        // Set an invalid config that would purposely cause the validation to fail.
        // The validator will still pass though because we won't be validating
        // the cache.
        Config::set('cache.default', null);

        $mailStubFilePath = __DIR__.'/../../Stubs/mail.php';
        $cacheStubFilePath = __DIR__.'/../../Stubs/cache.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/mail.php'), file_get_contents($mailStubFilePath));
        File::put(base_path('config-validation/cache.php'), file_get_contents($cacheStubFilePath));

        $configValidator = new ConfigValidator();
        $this->assertTrue($configValidator->run(['mail']));
    }

    /** @test */
    public function exception_is_thrown_if_the_validation_fails_with_a_custom_rule_message()
    {
        Config::set('mail.host', null);

        $this->expectException(InvalidConfigValueException::class);
        $this->expectExceptionMessage('This is a custom message.');

        $stubFilePath = __DIR__.'/../../Stubs/mail.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/mail.php'), file_get_contents($stubFilePath));

        $configValidator = new ConfigValidator();
        $configValidator->throwExceptionOnFailure(true)->run();
    }

    /** @test */
    public function exception_is_thrown_if_the_validation_fails()
    {
        Config::set('cache.default', null);

        $this->expectException(InvalidConfigValueException::class);
        $this->expectExceptionMessage('The cache.default must be a string.');

        $stubFilePath = __DIR__.'/../../Stubs/cache.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/cache.php'), file_get_contents($stubFilePath));

        $configValidator = new ConfigValidator();
        $configValidator->run();
    }

    /** @test */
    public function exception_is_thrown_if_the_directory_does_not_exist()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('The directory '.base_path('invalid_path').' does not exist.');

        $configValidator = new ConfigValidator();
        $configValidator->run([], 'invalid_path');
    }

    /** @test */
    public function exception_is_thrown_if_the_directory_contains_no_files()
    {
        $this->expectException(NoValidationFilesFoundException::class);
        $this->expectExceptionMessage('No config validation files were found inside the directory.');

        // Create a file that isn't a PHP file.
        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/cache.js'), 'https://ashallendesign.co.uk');

        $configValidator = new ConfigValidator();
        $configValidator->run();
    }

    /** @test */
    public function validation_error_messages_can_be_returned()
    {
        // Set valid config values that will pass all of the validation rules.
        Config::set('mail.from.address', 'mail@ashallendesign.co.uk');
        Config::set('mail.from.to', 'Ashley Allen');
        Config::set('mail.host', 'a random string');

        // Set invalid config values that will have their error messages stored.
        Config::set('cache.default', null);
        Config::set('cache.prefix', null);
        Config::set('mail.port', 'INVALID');

        $mailStubFilePath = __DIR__.'/../../Stubs/mail.php';
        $cacheStubFilePath = __DIR__.'/../../Stubs/cache.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/mail.php'), file_get_contents($mailStubFilePath));
        File::put(base_path('config-validation/cache.php'), file_get_contents($cacheStubFilePath));

        $configValidator = new ConfigValidator();

        $this->assertEquals([], $configValidator->errors());

        try {
            $configValidator->run();
        } catch (InvalidConfigValueException $e) {
            // Suppress the exception so that we can continue
            // testing the error output.
        }

        $this->assertEquals([
            'cache.default' => [
                'The cache.default must be a string.',
                'The cache.default field is required.',
            ],
            'cache.prefix' => [
                'The cache.prefix must be equal to foobar.',
            ],
            'mail.port'     => [
                'The mail.port must be an integer.',
            ],
        ], $configValidator->errors());
    }

    /** @test */
    public function exception_is_not_thrown_if_it_is_disabled_before_running_the_validator()
    {
        // Set invalid config values that will have their error messages stored.
        Config::set('cache.default', null);

        $cacheStubFilePath = __DIR__.'/../../Stubs/cache.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/cache.php'), file_get_contents($cacheStubFilePath));

        $configValidator = new ConfigValidator();
        $this->assertFalse($configValidator->throwExceptionOnFailure(false)->run());
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(base_path('config-validation'));

        parent::tearDown();
    }
}
