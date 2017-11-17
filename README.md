# Mobizon
Sms notifications channel for Laravel

This package makes it easy to send notifications using mobizon.kz with Laravel.

Installation

You can install the package via composer:

composer require laraketai/mobizon:dev-master

Publish the configs:

php artisan vendor:publish --provider="Laraketai\Mobizon\MobizonServiceProvider"

Then you must install the service provider:

// config/app.php
'providers' => [
    ...
    Laraketai\Mobizon\MobizonServiceProvider::class,
],
Install your Api key in the config:

// config/mobizon.php
return [
    'alphaname' => null,
    'secret' => 'Your secret API key',
];
Usage

You can use the channel in your via() method inside the notification:

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
In your notifiable model, make sure to include a routeNotificationForMobizon() method, which return the phone number.

public function routeNotificationForMobizon()
{
    return $this->phone;
}
