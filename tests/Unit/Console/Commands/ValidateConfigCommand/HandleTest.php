<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Console\Commands\ValidateConfigCommand;

use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use AshAllenDesign\ConfigValidator\Tests\Unit\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class HandleTest extends TestCase
{
    /** @test */
    public function command_can_be_run()
    {
        Config::set('cache.default', 'array');

        $this->createMockValidationFile();

        Artisan::call('config:validate');
        $this->assertEquals("Validating config...\nConfig validation passed!\n", Artisan::output());
    }

    /** @test */
    public function command_can_be_run_with_the_path_option()
    {
        $this->mock(ConfigValidator::class, function ($mock) {
            $mock->shouldReceive('throwExceptionOnFailure')->withArgs([false])->andReturn($mock);
            $mock->shouldReceive('run')->withArgs([[], 'hello']);
            $mock->shouldReceive('errors')->withNoArgs()->andReturn([]);
        });

        Artisan::call('config:validate --path=hello');
        $this->assertEquals("Validating config...\nConfig validation passed!\n", Artisan::output());
    }

    /** @test */
    public function command_can_be_run_with_the_files_option()
    {
        $this->mock(ConfigValidator::class, function ($mock) {
            $mock->shouldReceive('throwExceptionOnFailure')->withArgs([false])->andReturn($mock);
            $mock->shouldReceive('run')->withArgs([['auth', 'mail', 'telescope'], null]);
            $mock->shouldReceive('errors')->withNoArgs()->andReturn([]);
        });

        Artisan::call('config:validate --files=auth,mail,telescope');
        $this->assertEquals("Validating config...\nConfig validation passed!\n", Artisan::output());
    }

    private function createMockValidationFile()
    {
        $stubFilePath = __DIR__.'/../../../Stubs/cache.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/cache.php'), file_get_contents($stubFilePath));
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(base_path('config-validation'));

        parent::tearDown();
    }
}
