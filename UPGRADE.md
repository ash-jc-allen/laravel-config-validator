# Upgrade Guide

## Contents

- [Upgrading from 1.* to 2.0.0](#upgrading-from-1-to-200)

## Upgrading from 1.* to 2.0.0

### Minimum PHP Version

As of v2.0.0, support for PHP 7.3 and 7.4 is removed, so you'll need to use at least PHP 8.0.

### Minimum Laravel Version

As of v2.0.0, support for Laravel 6 and 7 is removed, so you'll need to use at least Laravel 8.

### Updated Default Directory

In previous versions of Laravel Config Validator, the config rules were stored by default in your Laravel application in a `config/validation` folder. This meant that if you ran the `artisan config:cache` command, an exception would be thrown because Laravel would attempt to cache your config validation rules.

So, as of v2.0.0, the default location has been moved from `config/validation` to `config-validation` in your project's root.

If you have any existing rules in your project, please make sure to move them to this new folder.
