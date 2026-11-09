# Upgrade Guide

## Contents

- [Upgrading from 2.* to 3.0.0](#upgrading-from-2-to-300)
- [Upgrading from 1.* to 2.0.0](#upgrading-from-1-to-200)

## Upgrading from 2.* to 3.0.0

### Minimum Laravel Version

As of v3.0.0, support for Laravel 10 is removed, so you'll need to use at least Laravel 11.

### Publishing Default Rulesets

Previously, you could publish the default rulesets using a single `config-validator-defaults` tag. However, this made maintenance difficult as Laravel's default config changed between versions. As of v3.0.0, the default rulesets are now published using version-specific tags.

The `config-validator-defaults` publishing tag has been replaced by version-specific tags:

```bash
# Laravel 11
php artisan vendor:publish --tag=config-validator-defaults-laravel-11

# Laravel 12
php artisan vendor:publish --tag=config-validator-defaults-laravel-12

# Laravel 13
php artisan vendor:publish --tag=config-validator-defaults-laravel-13
```

## Upgrading from 1.* to 2.0.0

### Minimum PHP Version

As of v2.0.0, support for PHP 7.3 and 7.4 is removed, so you'll need to use at least PHP 8.0.

### Minimum Laravel Version

As of v2.0.0, support for Laravel 6 and 7 is removed, so you'll need to use at least Laravel 8.

### Updated Default Directory

In previous versions of Laravel Config Validator, the config rules were stored by default in your Laravel application in a `config/validation` folder. This meant that if you ran the `artisan config:cache` command, an exception would be thrown because Laravel would attempt to cache your config validation rules.

So, as of v2.0.0, the default location has been moved from `config/validation` to `config-validation` in your project's root.

If you have any existing rules in your project, please make sure to move them to this new folder.
