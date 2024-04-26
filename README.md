<p align="center">
<img src="https://ashallendesign.co.uk/images/custom/laravel-config-validator-logo.png" width="500">
</p>

<p align="center">
<a href="https://packagist.org/packages/ashallendesign/laravel-config-validator"><img src="https://img.shields.io/packagist/v/ashallendesign/laravel-config-validator.svg?style=flat-square" alt="Latest Version on Packagist"></a>
<a href="https://travis-ci.org/ash-jc-allen/laravel-config-validator"><img src="https://img.shields.io/travis/ash-jc-allen/laravel-config-validator/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://packagist.org/packages/ashallendesign/laravel-config-validator"><img src="https://img.shields.io/packagist/dt/ashallendesign/laravel-config-validator.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/ashallendesign/laravel-config-validator"><img src="https://img.shields.io/packagist/php-v/ashallendesign/laravel-config-validator?style=flat-square" alt="PHP from Packagist"></a>
<a href="https://github.com/ash-jc-allen/laravel-config-validator/blob/master/LICENSE"><img src="https://img.shields.io/github/license/ash-jc-allen/laravel-config-validator?style=flat-square" alt="GitHub license"></a>
</p>

## Table of Contents

- [Overview](#overview)
- [Installation](#installation)
    - [Requirements](#requirements)
    - [Install the Package](#install-the-package)
    - [Publishing the Default Rulesets](#publishing-the-default-rulesets)
- [Usage](#usage)
    - [Creating a Validation Ruleset](#creating-a-validation-ruleset)
        - [Using the Generator Command](#using-the-generator-command)
        - [Ruleset Location](#ruleset-location)
        - [Adding Rules to a RuleSet](#adding-rules-to-a-ruleset)
        - [Custom Validation Error Messages](#custom-validation-error-messages)
        - [Only Running in Specific App Environments](#only-running-in-specific-app-environments)
    - [Running the Validation](#running-the-validation)
        - [Running the Validation Manually](#running-the-validation-manually)
            - [Only Running on Selected Config Files](#only-running-on-selected-config-files)
            - [Custom Folder Path](#custom-folder-path)
        - [Using the Command](#using-the-command)
            - [Only Running on Selected Config Files (Command)](#only-running-on-selected-config-files-command)
            - [Custom Folder Path (Command)](#custom-folder-path-command)
        - [Using a Service Provider](#using-a-service-provider)
        - [Throwing and Preventing Exceptions](#throwing-and-preventing-exceptions)
    - [Facade](#facade)
- [Security](#security)
- [Contribution](#contribution)
- [Changelog](#changelog)
- [Upgrading](#upgrading)
- [License](#license)

## Overview

A Laravel package that allows you to validate your config values and environment.

## Installation

### Requirements
The package has been developed and tested to work with the following minimum requirements:

- PHP 8.0
- Laravel 8

### Install the Package
You can install the package via Composer:

```bash
composer require ashallendesign/laravel-config-validator
```

### Publishing the Default Rulesets

To get you started with validating your app's config, Laravel Config Validator comes with some default rulesets. To start
using these rulesets, you can publish them using the following command:

```bash
php artisan vendor:publish --tag=config-validator-defaults
```

The above command will copy the validation files and place in a ` config-validation ` folder in your project's root. These rules
are just to get you started, so there are likely going to be rule in the files that don't apply to your app. So, once you've
published them, feel free to delete them or edit them as much as you'd like.

## Usage

### Creating a Validation Ruleset

#### Using the Generator Command

This package comes with a command that you can use to quickly create a validation file to get you started right away.
Lets say that you wanted to create a validation file for validating the config in the ``` config/app.php ``` file. To do
this, you could use the following command:

```bash
php artisan make:config-validation app
```

Running the above command would create a file in ``` config-validation/app.php ``` ready for you to start adding your config
validation.

#### Ruleset Location

To validate your application's config, you need to define the validation rules first. You can do this by placing them inside
files in a ``` config-validation ``` folder with names that match the config file you're validating. As an example, to
validate the ``` config/app.php ``` config file, you would create a new file at ``` config-validation/app.php ``` that
would hold the rules.

#### Adding Rules to a Ruleset

Once you have your ruleset file created in the ``` config-validation ``` folder, you can start adding your validation
rules.

Under the hood, Laravel Config Validator uses the built-in ``` Validator ``` class, so it should seem pretty familiar
to work with. To check out the available Laravel validation rules that can be used, [click here](https://laravel.com/docs/8.x/validation#available-validation-rules).

As an example, we might want to add a config validation rule to ensure that the ``` driver ``` field in the ``` app/mail.php ```
file is a supported field. To do this, we could create a file at ``` config-validation/mail.php ``` with the following:

```php
<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('driver')->rules(['in:smtp,sendmail,mailgun,ses,postmark,log,array']),
    // ...
];
```

#### Custom Validation Error Messages

There may be times when you want to override the error message for a specific validation rule. This can be done by passing
in an array containing the messages to the ``` ->messages() ``` method for a ``` Rule ```. This array should follow the same
pattern that would be used in a standard Laravel Validator object.

As an example, we might want to add a config validation rule to ensure that the ``` driver ``` field in the ``` app/mail.php ```
file is a supported field and also use a custom error message. To do this, we could update our validation file to the following:

```php
<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('driver')
        ->rules(['in:smtp,sendmail,mailgun,ses,postmark,log,array'])
        ->messages(['in' => 'The mail driver is invalid']),
    // ...
];
```

#### Only Running in Specific App Environments

You might not always want the same rule to be run in different environments. For example, you might want to have a relaxed
set of validation rules for your local development environment and have a stricter set of rules for production.

To explicitly specify the environment that a rule can be run in, you can use the ``` ->environments() ``` method. If no
environment is defined, the rule will be run in all environments.

The following example shows how you could set 2 different rules, one for production and one for local:

```php
<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('driver')
        ->rules(['in:smtp,sendmail,mailgun,ses,postmark,log,array'])
        ->environments([Rule::ENV_LOCAL]),
    
    Rule::make('driver')
        ->rules(['in:mailgun'])
        ->environments([Rule::ENV_PRODUCTION])
];
```

### Running the Validation

#### Running the Validation Manually

To run the config validation you can call the ``` ->run() ``` method on a ``` ConfigValidator ``` object. The example below
shows how you could do this in a controller:

```php
<?php
    
namespace App\Http\Controllers;

use AshAllenDesign\ConfigValidator\Services\ConfigValidator;

class TestController extends Controller
{
    public function index()
    {
        $configValidator = new ConfigValidator();

        $configValidator->run();

        return response()->json(['success' => true]);
    }
}
```

##### Only Running on Selected Config Files

You might not always want to validate all of the config values in your application. So, you can specify the config files
that you want to validate by passing the config names to the ``` ->run() ``` method as the first parameter. As an example, if you only wanted to validate
the ``` auth.php ``` config file, you could use the following:

```php
$configValidator = new ConfigValidator();

$configValidator->run(['auth']);
```

##### Custom Folder Path

If you aren't storing your validation files in the default ``` config/validation ``` folder, you can pass a custom folder path
into the ``` ->run() ``` method as the second parameter. As an example, if you had the files stored in a ``` app/Custom/Validation ``` folder, you
could use the following:

```php
$configValidator = new ConfigValidator();

$configValidator->run([], 'app/Custom/Validation');
```

##### Running the Validator with Inline Rules

There may be times when you want to run the validator with inline rules instead of using the rules defined in your config validation files. This can be useful if you want to run a one-off validation check, or validate the config values inside a package you maintain.

To do this, you can use the `runInline` method like so:

```php
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use AshAllenDesign\ConfigValidator\Services\Rule;

$configValidator = new ConfigValidator();

$configValidator->runInline([
    'app' => [
        Rule::make('env')->rules(['in:local,production']),
        Rule::make('debug')->rules(['boolean']),
    ],
    'mail' => [
        Rule::make('driver')->rules(['in:smtp,sendmail,mailgun,ses,postmark,log,array']),
    ],
]);
```

In the example above, we're running the validator with inline rules for the `app` and `mail` config files. The rules are the same as the ones we would define in the config validation files.

The behaviour of the `runInline` method is the same as the `run` method. It will throw an exception if the validation fails, or return a boolean value if the `throwExceptionOnFailure` method has been set to `false`.

#### Using the Command

The library comes with a useful command that you can use to validate your config. To use it, you can run the following in
the command line:

```bash
php artisan config:validate
```

##### Only Running on Selected Config Files (Command)

You might not always want to validate all of the config values in your application. So, you can specify the config files
that you want to validate in the command using the ``` --files ``` option. As an example, if you only wanted to validate
the ``` auth.php ``` config file, you could use the following:

```bash
php artisan config:validate --files=auth
```

As a further example, if you wanted to validate the ``` auth.php ``` and ``` app.php ``` files, you could use the following:

```bash
php artisan config:validate --files=auth,app
```

##### Custom Folder Path (Command)

If you aren't storing your validation files in the default ``` config/validation ``` folder, you can pass a custom folder path
into the ``` --path ``` option. As an example, if you had the files stored in a ``` app/Custom/Validation ``` folder, you
could use the following:

```bash
php artisan config:validate --path=app/Custom/Validation
```

#### Using a Service Provider

You might want to run the config validator automatically on each request to ensure that you have the correct config. This
can be particularly useful if you are in a local environment and switching between Git branches often. However, you might
not want it to always run automatically in production for performance reasons. To run the validation automatically on each
request, you can add it to the ``` boot ``` method of a service provider.

The example below shows how to only run the validation in the local environment using the ``` AppServiceProvider ```:

```php
<?php

namespace App\Providers;

use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(ConfigValidator $configValidator)
    {
        if (App::environment() === 'local') {
            $configValidator->run();
        }
    }
}

```

#### Throwing and Preventing Exceptions

By default, the ` ConfigValidator ` will throw an ` InvalidConfigValueException ` exception if the validation fails. The exception will contain
the error message of the first config value that failed the validation. You can prevent the exception from being thrown and instead
rely on the boolean return value of the ` ->run() ` method by using the ` ->throwExceptionOnFailure() ` method.

By preventing any exceptions from being thrown, it makes it easier for you to get all the failed validation errors using the
` ->errors() ` method. This will return the errors as an array.

The example belows shows how you could prevent any exceptions from being thrown so that you can grab the errors:

```php
$configValidator = new ConfigValidator();

$configValidator->throwExceptionOnFailure(false)
                ->run();

$errors = $configValidator->errors();
```

### Facade

If you prefer to use facades in Laravel, you can choose to use the provided ``` ConfigValidator ``` facade instead of instantiating the ``` AshAllenDesign\ConfigValidator\Classes\ConfigValidator ```
class manually.

The example below shows an example of how you could use the facade to run the config validation:

```php
<?php
    
namespace App\Http\Controllers;

use ConfigValidator;

class TestController extends Controller
{
    public function index()
    {
        ConfigValidator::run();

        return response()->json(['success' => true]);
    }
}
```

## Security

If you find any security related issues, please contact me directly at [mail@ashallendesign.co.uk](mailto:mail@ashallendesign.co.uk) to report it.

## Contribution

If you wish to make any changes or improvements to the package, feel free to make a pull request.

Note: A contribution guide will be added soon.

## Changelog

Check the [CHANGELOG](CHANGELOG.md) to get more information about the latest changes.

## Upgrading

Check the [UPGRADE](UPGRADE.md) guide to get more information on how to update this library to newer versions.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support Me

If you've found this package useful, please consider buying a copy of [Battle Ready Laravel](https://battle-ready-laravel.com) to support me and my work.

Every sale makes a huge difference to me and allows me to spend more time working on open-source projects and tutorials.

To say a huge thanks, you can use the code **BATTLE20** to get a 20% discount on the book.

[👉 Get Your Copy!](https://battle-ready-laravel.com)

[![Battle Ready Laravel](https://ashallendesign.co.uk/images/custom/sponsors/battle-ready-laravel-horizontal-banner.png)](https://battle-ready-laravel.com)
