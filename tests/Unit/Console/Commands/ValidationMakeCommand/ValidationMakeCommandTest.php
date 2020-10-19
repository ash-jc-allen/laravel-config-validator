<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Console\Commands\ValidationMakeCommand;

use AshAllenDesign\ConfigValidator\Tests\Unit\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ValidationMakeCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(config_path('validation'));
    }

    /** @test */
    public function validation_file_can_be_created()
    {
        $validationFile = config_path('validation/app.php');

        // Delete the validation folder so that we can be
        // sure we have a new slate for testing.
        File::deleteDirectory(config_path('validation'));

        $this->assertFalse(File::exists($validationFile));

        Artisan::call('make:config-validation app');

        $this->assertTrue(File::exists($validationFile));

        $this->assertEquals($this->expectedFileContents(), file_get_contents($validationFile));
    }

    private function expectedFileContents(): string
    {
        return "<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('')->rules([]),
];
";
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(config_path('validation'));

        parent::tearDown();
    }
}
