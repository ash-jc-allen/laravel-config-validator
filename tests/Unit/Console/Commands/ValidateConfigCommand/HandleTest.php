<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Console\Commands\ValidateConfigCommand;

use AshAllenDesign\ConfigValidator\Exceptions\DirectoryNotFoundException;
use AshAllenDesign\ConfigValidator\Exceptions\NoValidationFilesFoundException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use AshAllenDesign\ConfigValidator\Tests\Unit\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\renderUsing;

class HandleTest extends TestCase
{
    private BufferedOutput $output;

    public function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(base_path('config-validation'));
    }

    /** @test */
    public function command_can_be_run(): void
    {
        Config::set('cache.default', 'array');
        Config::set('cache.prefix', 'foobar');

        $this->createMockValidationFile();

        $output = $this->runCommand('config:validate');

        $this->assertStringContainsString('Config validation passed!', $output);
    }

    /** @test */
    public function command_can_be_run_with_the_path_option(): void
    {
        $this->mock(ConfigValidator::class, function ($mock) {
            $mock->shouldReceive('throwExceptionOnFailure')->withArgs([false])->andReturn($mock);
            $mock->shouldReceive('run')->withArgs([[], 'hello']);
            $mock->shouldReceive('errors')->withNoArgs()->andReturn([]);
        });

        $output = $this->runCommand('config:validate --path=hello');
        $this->assertStringContainsString('Config validation passed!', $output);
    }

    /** @test */
    public function command_can_be_run_with_the_files_option(): void
    {
        $this->mock(ConfigValidator::class, function ($mock) {
            $mock->shouldReceive('throwExceptionOnFailure')->withArgs([false])->andReturn($mock);
            $mock->shouldReceive('run')->withArgs([['auth', 'mail', 'telescope'], null]);
            $mock->shouldReceive('errors')->withNoArgs()->andReturn([]);
        });

        $output = $this->runCommand('config:validate --files=auth,mail,telescope');

        $this->assertStringContainsString('Config validation passed!', $output);
    }

    /** @test */
    public function error_is_displayed_if_a_config_validation_fails(): void
    {
        $this->mock(ConfigValidator::class, function ($mock) {
            $mock->shouldReceive('throwExceptionOnFailure')->withArgs([false])->andReturn($mock);
            $mock->shouldReceive('run')->withArgs([['auth', 'mail', 'telescope'], null]);
            $mock->shouldReceive('errors')->withNoArgs()->andReturn([
                'cache.default' => [
                    'The cache.default must be a string.',
                    'The cache.default field is required.',
                ],
                'cache.prefix' => [
                    'The cache.prefix must be equal to foobar.',
                ],
                'mail.port' => [
                    'The mail.port must be an integer.',
                ],
            ]);
        });

        $output = $this->runCommand('config:validate --files=auth,mail,telescope');

        $this->assertStringContainsString('Config validation failed!', $output);
        $this->assertStringContainsString('3 errors found in your application:', $output);

        $this->assertStringContainsString('cache.default', $output);
        $this->assertStringContainsString('The cache.default must be a string.', $output);
        $this->assertStringContainsString('The cache.default field is required.', $output);

        $this->assertStringContainsString('cache.prefix', $output);
        $this->assertStringContainsString('The cache.prefix must be equal to foobar.', $output);

        $this->assertStringContainsString('mail.port', $output);
        $this->assertStringContainsString('The mail.port must be an integer.', $output);
    }

    /** @test */
    public function error_is_displayed_if_a_directory_does_not_exist(): void
    {
        $this->mock(ConfigValidator::class, function (MockInterface $mock): void {
            $mock->shouldReceive('throwExceptionOnFailure')
                ->withArgs([false])
                ->andReturn($mock);

            $mock->shouldReceive('run')
                ->withArgs([[], null])
                ->andThrow(new DirectoryNotFoundException('The directory does not exist.'));
        });

        $output = $this->runCommand('config:validate');

        $this->assertStringContainsString('The directory does not exist.', $output);
    }

    /** @test */
    public function error_is_displayed_if_a_directory_is_empty(): void
    {
        $this->mock(ConfigValidator::class, function (MockInterface $mock): void {
            $mock->shouldReceive('throwExceptionOnFailure')
                ->withArgs([false])
                ->andReturn($mock);

            $mock->shouldReceive('run')
                ->withArgs([[], null])
                ->andThrow(new NoValidationFilesFoundException('The directory does not contain any validation files.'));
        });

        $output = $this->runCommand('config:validate');

        $this->assertStringContainsString('The directory does not contain any validation files.', $output);
    }

    private function createMockValidationFile(): void
    {
        $stubFilePath = __DIR__ . '/../../../Stubs/cache.php';

        File::makeDirectory(base_path('config-validation'));
        File::put(base_path('config-validation/cache.php'), file_get_contents($stubFilePath));
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(base_path('config-validation'));

        parent::tearDown();
    }

    private function runCommand(string $command): string
    {
        $output = new BufferedOutput();
        renderUsing($output);

        Artisan::call($command);

        return $output->fetch();
    }
}
