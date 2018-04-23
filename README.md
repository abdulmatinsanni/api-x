# api-x

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

An unofficial laravel package for SmartSMSSolutions' API-x. The Package that helps deliver SMS to phone numbers on Do Not Disturb (DND).

## Structure

Below is the file structure of this package.

```
src/
    Commands/
        Log/
            ClearCommand.php
            DisplayCommand.php
    config/
        api-x.php
    Controllers/
        LogController.php
    Facades/
        APIxFacade.php
    resources/
        views/
            log.blade.php
    APIx.php
    APIxServiceProvider.php
tests/
```


## Install

You can install the package via composer:

``` bash
$ composer require abdulmatinsanni/api-x
```

Add the service provider (only required on Laravel 5.4 or lower):

``` php
// config/app.php

'providers' => [
    ...
    AbdulmatinSanni\APIx\APIxServiceProvider::class,
],

'aliases' => [
    'APIx' => AbdulmatinSanni\APIx\Facades\APIxFacade::class,
],
```

## Setting up your API-x account
Add your API-x API Token (string), Log Message (boolean), Mock SMS (boolean) and Sender Name (optional|string) to your .env (environment) file:
```$xslt
SMARTSMSSOLUTIONS_API_TOKEN=apixtokenhere
SMARTSMSSOLUTIONS_LOG_MESSAGES=true
SMARTSMSSOLUTIONS_FAKE_SMS=true
SMARTSMSSOLUTIONS_SENDER_NAME=sendernamehere
```

## Usage
### In controller:
``` php
...
use APIx;

class SMSController extends Controller
{
    public function send(Request $request)
    {
        $response = APIx::to($request->recipient)
            ->from($request->name)
            ->message($request->message)
            ->send();
        
        return $response;
    }
}
```

#### Available message methods
- ```to([]) ```: Accepts an array or string of recipients' phone number(s).
- ```from('') ```: Accepts a phone to use as the sms sender.
- ```message('') ```: Accepts a string value for the sms body.
- ```send() ```: Does the sending of the sms. Can also accept a string which represent sms body if message('') was skipped.

### Command line

Showing all entries of log:
``` bash
$ php artisan api-x:log
```

Showing the last logged sms:
``` bash
$ php artisan api-x:log --last
```

Limiting the entries of log to be displayed:
``` bash
$ php artisan api-x:log --limit={no_of_messages}
```
Clearing all entries of log:
``` bash
$ php artisan api-x:log clear
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email me@abdulmatinsanni.com instead of using the issue tracker.

## Credits

- [Abdulmatin Sanni][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/abdulmatinsanni/api-x.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/abdulmatinsanni/api-x/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/abdulmatinsanni/api-x.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/abdulmatinsanni/api-x.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/abdulmatinsanni/api-x.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/abdulmatinsanni/api-x
[link-travis]: https://travis-ci.org/abdulmatinsanni/api-x
[link-scrutinizer]: https://scrutinizer-ci.com/g/abdulmatinsanni/api-x/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/abdulmatinsanni/api-x
[link-downloads]: https://packagist.org/packages/abdulmatinsanni/api-x
[link-author]: https://github.com/https://github.com/abdulmatinsanni
[link-contributors]: ../../contributors
