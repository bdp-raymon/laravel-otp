# Laravel Module to Facilitate the One-Time Password Authentication

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alish/laravel-otp.svg?style=flat-square)](https://packagist.org/packages/alish/laravel-otp)
[![Build Status](https://api.travis-ci.org/bdp-raymon/laravel-otp.svg?branch=main)](https://travis-ci.org/bdp-raymon/laravel-otp)
[![Quality Score](https://img.shields.io/scrutinizer/g/bdp-raymon/laravel-otp.svg?style=flat-square)](https://scrutinizer-ci.com/g/bdp-raymon/laravel-otp)
[![Total Downloads](https://img.shields.io/packagist/dt/alish/laravel-otp.svg?style=flat-square)](https://packagist.org/packages/alish/laravel-otp)

One-Time Password Authentication has gained noticeable popularity amongst software developers, due to its reliablity and ease of use. Using this module, you are able to embedd OTP to your Laravel project in a considerably straightforward manner. This Package is equipped with both Cache and Database drivers to provide developers with the freedom of choice, regarding the unit supposed to hold the OTP and other related information. 

## Installation

You can install the package via composer:

```bash
composer require alish/laravel-otp
```

## Usage

The first step to take in order to use this package, is finding the storage method that suits your needs best. This module is compatible with both Cache and Database.

The whole functionality of the One-Time Password Authentication is provided through the methods provided in the __Otp__ interface, available in the __Contracts__ folder of the __src__ folder. The referenced interface, includes following methods:

* issue: This method is responsible to both creation and storage of the OTP in the chosen mean of storage.

* revoke: This method is used to deactivate a token. Besides using the token, its expiration results in the deactivation of the token.

* check: Using this method, we are able to validate a pair of __Key__ and __Token__.

* use: This method is used to provide a pair of __Key__ and __Token__ to authenticate.

Keep in mind that if database driver is your prefered choice, you are supposed to publish migrations file first:

```bash
php artisan vendor:publish --provider="Alish\LaravelOtp\OtpServiceProvider" --tag=migrations
```

then run your migrations with

```bash
php artisan migrate
```

In order to be able to adjust the configuration of this package, you are supposed to publish your configurations using the following command:

```bash
php artisan vendor:publish --provider="Alish\LaravelOtp\OtpServiceProvider" --tag=config
```

* default: Using this value, you are able to modify the default method to store the OTP and other related information.

* type: This variable determines the type of the characters included in the OTP. Choices are alpha, alphanumeric, and numeric.

* length: By changing this variable, you are able to determine the number of the characters that OTP has.


* case-sensitive: Using this variable, you are able to control the sensetivity of the package to case sentivity.

* custom': Pass the set of the characters you want to create your custom OTPs from as a simple string (eg: "1234") to this variable.

* timeout: This variable determines the time (in seconds), which the token is active to use. To set a token active permenantly, set timeout to null.

* hash: Using this variable, you are able to determine if the token should be hashed or not.

* unique: Using this variable, you are able to revoke all generated tokens after creating a new one, for an specific key. This functionality is only available for Database Driver.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email alishabani9270@gmail.com instead of using the issue tracker.

## Credits

- [Ali Shabani](https://github.com/alish)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
