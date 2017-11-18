# Mobizon notifications channel for Laravel 5.3+


This package makes it easy to send notifications using [mobizon.kz](//mobizon.kz) (aka Mobizon) with Laravel 5.3+.

## Contents

- [Installation](#installation)
    - [Setting up the Mobizon service](#setting-up-the-Mobizon-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

```bash
composer require laraketai/mobizon:dev-master
```

Then you must install the service provider:
```php
// config/app.php
'providers' => [
    ...
    Laraketai\Mobizon\MobizonServiceProvider::class,
],
```

Publish the configs:
```bash
php artisan vendor:publish --provider="Laraketai\Mobizon\MobizonServiceProvider"
```


### Setting up the Mobizon service

Add your secret key (Your secret API key) and alphaname to your `config/mobizon.php`:

```php
// config/services.php
...
return [
    'alphaname' => null, //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
    'secret' => env('MOBIZON_APP_KEY'), // Your secret API key
];

...
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use Laraketai\Mobizon\MobizonMessage;
use Laraketai\Mobizon\MobizonChanel;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [MobizonChanel::class];
    }

    public function toMobizon($notifiable)
    {
        return MobizonMessage::create("Task #{$notifiable->id} is complete!");
    }
}
```

In your notifiable model, make sure to include a routeNotificationForMobizon() method, which return the phone number.

```php
public function routeNotificationForMobizon()
    {
        return $this->phone;
    }
```

### Available methods

`content()`: Set a content of the notification message.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email sanzhar@aketai.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Laraketai](https://github.com/laraketai)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
