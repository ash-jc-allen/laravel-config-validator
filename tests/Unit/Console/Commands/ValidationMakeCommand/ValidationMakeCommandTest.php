<?php

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Console\Commands\ValidationMakeCommand;

use AshAllenDesign\ConfigValidator\Tests\Unit\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ValidationMakeCommandTest extends TestCase
{
    /** @test */
    public function executor_can_be_created_with_the_command()
    {
        $validationFile = config_path('validation/app.php');

        // Delete the executor and it's command if it exists
        // so that we can be sure we have a new slate for
        // testing.
        if (File::exists($validationFile)) {
            unlink($validationFile);
        }

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
}
