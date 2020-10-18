<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Console\Commands\ValidateConfigCommand;

use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use AshAllenDesign\ConfigValidator\Tests\Unit\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class HandleTest extends TestCase
{
    /** @test */
    public function command_can_be_run()
    {
        $this->createMockValidationFile();

        Artisan::call('config:validate');
        $this->assertEquals("Validating config...\nConfig validation passed!\n", Artisan::output());
    }

    /** @test */
    public function command_can_be_run_with_the_path_option()
    {
        $this->mock(ConfigValidator::class, function ($mock) {
            $mock->shouldReceive('run')->withArgs([[], 'hello']);
        });

        Artisan::call('config:validate --path=hello');
        $this->assertEquals("Validating config...\nConfig validation passed!\n", Artisan::output());
    }

    /** @test */
    public function command_can_be_run_with_the_files_option()
    {
        $this->mock(ConfigValidator::class, function ($mock) {
            $mock->shouldReceive('run')->withArgs([['auth', 'mail', 'telescope'], null]);
        });

        Artisan::call('config:validate --files=auth,mail,telescope');
        $this->assertEquals("Validating config...\nConfig validation passed!\n", Artisan::output());
    }

    private function createMockValidationFile()
    {
        $stubFilePath = __DIR__.'/../../../Stubs/Valid/cache.php';

        if (file_exists(config_path('validation'))) {
            rmdir(config_path('validation'));
        }

        File::makeDirectory(config_path('validation'));
        File::put(config_path('validation/cache.php'), file_get_contents($stubFilePath));
    }
}
