# Changelog

**v2.1.0 (released 2022-04-02):**
- Improved command output using Termwind. Huge thanks to @xiCO2k for this! [#38](https://github.com/ash-jc-allen/laravel-config-validator/pull/38)
- Removed unneeded `illuminate/cache` dependency requirement. Added dependency requirement for `illuminate/command`. [#40](https://github.com/ash-jc-allen/laravel-config-validator/pull/40)
- Removed old and unneeded exceptions. [#39](https://github.com/ash-jc-allen/laravel-config-validator/pull/39)
- Fixed bug that was removing underscores from validation error messages. [#43](https://github.com/ash-jc-allen/laravel-config-validator/pull/43)
- Updated the PHPUnit config file to the newest format. [#45](https://github.com/ash-jc-allen/laravel-config-validator/pull/45)

**v2.0.0 (released 2022-03-22):**
- Added support for Laravel 9 and PHP 8.1. [#32](https://github.com/ash-jc-allen/laravel-config-validator/pull/32)
- Dropped support for Laravel 6 and 7. [#32](https://github.com/ash-jc-allen/laravel-config-validator/pull/32)
- Dropped support for PHP 7.3 and  7.4. [#32](https://github.com/ash-jc-allen/laravel-config-validator/pull/32)
- Migrated from TravisCI to GitHub Actions for running tests. [#35](https://github.com/ash-jc-allen/laravel-config-validator/pull/35)
- Added Larastan workflow to run on GitHub Actions. [#34](https://github.com/ash-jc-allen/laravel-config-validator/pull/34)
- Added type hints and fields types. [#35](https://github.com/ash-jc-allen/laravel-config-validator/pull/35)
- Changed default directory from `config/validation` to `config-validation`. [#31](https://github.com/ash-jc-allen/laravel-config-validator/pull/31)
- Moved default config rulesets to `stubs/config-validation`. [#36](https://github.com/ash-jc-allen/laravel-config-validator/pull/36)
- Fixed bug that prevented Rule objects from being used. [#33](https://github.com/ash-jc-allen/laravel-config-validator/pull/33)

**v1.3.0 (released 2020-12-06):**
- Added support for PHP 8.

**v1.2.0 (released 2020-11-06):**
- Added default config rulesets that can be published. [#26](https://github.com/ash-jc-allen/laravel-config-validator/pull/26)

**v1.1.0 (released 2020-10-28):**
- Added a new ` errors() `  method to the ` ConfigValidator ` class. [#22](https://github.com/ash-jc-allen/laravel-config-validator/pull/22)
- Added a new ` throwExceptionOnFailure() ` method to the ` ConfigValidator ` class. [#23](https://github.com/ash-jc-allen/laravel-config-validator/pull/23)
- Updated the validation console command output to be more readable and contain all the validation error messages. [#24](https://github.com/ash-jc-allen/laravel-config-validator/pull/23)

**v1.0.0:**
- Initial production release.
- Added a generator command that can be used for making new config validation files.

**v0.4.0:**
- Increased minimum supported PHP version to PHP 7.3.
- Added PHPUnit tests.
- Fixed a bug that prevented more than one nested config item from being validated.
- Updated the validator to return ``` true ``` after successfully running.

**v0.3.0:**
- Added checks that validate whether if the config folder exists and if the folder contains any validation files.

**v0.2.1:**
- Fixed a bug that prevented nested config items from being validated.

**v0.2.0:**
- Added the functionality to set environment-specific rules.

**v0.1.1:**
- Documentation updates.

**v0.1.0:**
- Pre-release development.
