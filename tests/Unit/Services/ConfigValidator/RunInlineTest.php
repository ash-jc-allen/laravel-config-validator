<?php

declare(strict_types=1);

namespace AshAllenDesign\ConfigValidator\Tests\Unit\Services\ConfigValidator;

use AshAllenDesign\ConfigValidator\Exceptions\InvalidConfigValueException;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use AshAllenDesign\ConfigValidator\Services\Rule;
use AshAllenDesign\ConfigValidator\Tests\Unit\Stubs\IsFooBar;
use AshAllenDesign\ConfigValidator\Tests\Unit\TestCase;
use Illuminate\Support\Facades\Config;

final class RunInlineTest extends TestCase
{
    /** @test */
    public function validator_can_be_run_inline_and_pass(): void
    {
        // Set valid config values that will pass all the validation rules.
        Config::set('mail.from.address', 'mail@ashallendesign.co.uk');
        Config::set('mail.from.to', 'Ashley Allen');
        Config::set('mail.host', 'a random string');
        Config::set('mail.port', 1234);
        Config::set('cache.prefix', 'foobar');

        Config::set('short-url.tracking.fields.ip_address', true);
        Config::set('short-url.tracking.fields.user_agent', true);

        $configValidator = new ConfigValidator();

        $this->assertTrue(
            $configValidator->runInline([
                'mail' => $this->mailRules(),
                'cache' => $this->cacheRules(),
                'short-url' => [
                    Rule::make('tracking.fields.ip_address')->rules(['required', 'boolean']),
                    Rule::make('tracking.fields.user_agent')->rules(['required', 'boolean']),
                ],
            ]),
        );
    }

    /** @test */
    public function exception_is_thrown_if_the_validation_fails_with_a_custom_rule_message(): void
    {
        Config::set('mail.host', null);

        $this->expectException(InvalidConfigValueException::class);
        $this->expectExceptionMessage('This is a custom message.');

        $configValidator = new ConfigValidator();
        $configValidator->throwExceptionOnFailure(true)->runInline([
            'mail' => $this->mailRules(),
        ]);
    }

    /** @test */
    public function exception_is_thrown_if_the_validation_fails(): void
    {
        Config::set('cache.default', null);

        $this->expectException(InvalidConfigValueException::class);

        // The validation failed message structure changed in Laravel 10.
        // So we need to check for both messages depending on the
        // Laravel framework version.
        if (version_compare(app()->version(), '10.0.0', '>=')) {
            $this->expectExceptionMessage('The cache.default field must be a string.');
        } else {
            $this->expectExceptionMessage('The cache.default must be a string.');
        }

        $configValidator = new ConfigValidator();
        $configValidator->runInline([
            'cache' => $this->cacheRules(),
        ]);
    }

    /** @test */
    public function validation_error_messages_can_be_returned(): void
    {
        // Set valid config values that will pass all of the validation rules.
        Config::set('mail.from.to', 'Ashley Allen');
        Config::set('mail.host', 'a random string');

        // Set invalid config values that will have their error messages stored.
        Config::set('mail.from.address', 'INVALID');
        Config::set('cache.default', null);
        Config::set('cache.prefix', null);
        Config::set('mail.port', 'INVALID');
        Config::set('mail.field_with_underscores', 'INVALID');

        $configValidator = new ConfigValidator();

        $this->assertEquals([], $configValidator->errors());

        try {
            $configValidator->runInline([
                'mail' => $this->mailRules(),
                'cache' => $this->cacheRules(),
            ]);
        } catch (InvalidConfigValueException $e) {
            // Suppress the exception so that we can continue
            // testing the error output.
        }

        // The validation failed message structure changed in Laravel 10.
        // So we need to check for both messages depending on the
        // Laravel framework version.
        if (version_compare(app()->version(), '10.0.0', '>=')) {
            $this->assertEquals([
                'cache.default' => [
                    'The cache.default field must be a string.',
                    'The cache.default field is required.',
                ],
                'cache.prefix' => [
                    'The cache.prefix must be equal to foobar.',
                ],
                'mail.from.address' => [
                    'The mail.from.address field must be a valid email address.',
                ],
                'mail.port' => [
                    'The mail.port field must be an integer.',
                ],
                'mail.field_with_underscores' => [
                    'The mail.field_with_underscores field must be an integer.',
                ],
            ], $configValidator->errors());
        } else {
            $this->assertEquals([
                'cache.default' => [
                    'The cache.default must be a string.',
                    'The cache.default field is required.',
                ],
                'cache.prefix' => [
                    'The cache.prefix must be equal to foobar.',
                ],
                'mail.from.address' => [
                    'The mail.from.address must be a valid email address.',
                ],
                'mail.port' => [
                    'The mail.port must be an integer.',
                ],
                'mail.field_with_underscores' => [
                    'The mail.field_with_underscores must be an integer.',
                ],
            ], $configValidator->errors());
        }
    }

    /** @test */
    public function exception_is_not_thrown_if_it_is_disabled_before_running_the_validator(): void
    {
        // Set invalid config values that will have their error messages stored.
        Config::set('cache.default', null);

        $configValidator = new ConfigValidator();
        $this->assertFalse(
            $configValidator->throwExceptionOnFailure(false)->runInline([
                'cache' => $this->cacheRules(),
            ]),
        );
    }

    private function mailRules(): array
    {
        return [
            Rule::make('host')->rules(['string'])->messages(['string' => 'This is a custom message.']),
            Rule::make('port')->rules(['integer']),
            Rule::make('from.address')->rules(['email', 'required']),
            Rule::make('from.to')->rules(['string', 'required']),
            Rule::make('field_with_underscores')->rules(['integer', 'nullable']),
        ];
    }

    private function cacheRules(): array
    {
        return [
            Rule::make('default')->rules(['string', 'required', 'in:apc,array,database,file,memcached,redis,dynamodb']),
            Rule::make('prefix')->rules([new IsFooBar()]),
        ];
    }
}
