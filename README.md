# Zoho Cliq Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/:package_name.svg?style=flat-square)](https://packagist.org/packages/mehrdadep/laravel-zoho-cliq)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes it easy to send notifications using [Zoho Cliq](https://www.zoho.com/nl/cliq/) with Laravel 5.5+, 6.x and 7.x

## Contents

- [Installation](#installation)
	- [Setting up the Zoho Cliq service](#setting-up-the-zoho-cliq-service)
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

```
composer require mehrdadep/laravel-zoho-cliq
```

Next, if you're using Laravel without auto-discovery, add the service provider to config/app.php:

```
'providers' => [
// ...
NotificationChannels\ZohoCliq\ZohoCliqServiceProvider::class,
],
```

### Setting up the Zoho Cliq service

Create a [webhook token](https://cliq.zoho.com/integrations/webhook-tokens) and follow the guides from [here](https://www.zoho.com/cliq/help/restapi/v2/#Post_Message_Channel) to set up a bot or post to the channel directly with the user (e.g. `https://cliq.zoho.com/api/v2/channelsbyname/alerts/message?zapikey=2002.1c84cd1a2ffd304f57d44ecddc157d59.127g8g495367a04017a2d9af0bc5666f8&bot_unique_name=custombot`)
Then, configure your webhook url:

Add the following code to your `config/services.php`:

```
// config/services.php
...
'zoho_cliq' => [
'webhook_url' => env('ZOHO_CLIQ_WEBHOOK_URL'),
],
...
```

You can also add multiple webhooks if you have multiple teams or channels, it's up to you.

```
// config/services.php
...
'zoho_cliq' => [
    'sales_url' => env('ZOHO_CLIQ_SALES_WEBHOOK_URL'),
    'dev_url' => env('ZOHO_CLIQ_DEV_WEBHOOK_URL'),
],
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

```
use Illuminate\Notifications\Notification;
use NotificationChannels\ZohoCliq\ZohoCliqChannel;
use NotificationChannels\ZohoCliq\ZohoCliqMessage;

class SubscriptionCreated extends Notification
{
public function via($notifiable)
{
return [ZohoCliqChannel::class];
}

    public function toZohoCliq($notifiable)
    {
        return ZohoCliqMessage::create()
            ->to(config('services.zoho_cliq.sales_url'))
            ->payload(["text" => "a sample message"]);
    }
}
```

Instead of adding the `to($url)` method for the recipient you can also add the `routeNotificationForZohoCliq` method inside your Notifiable model. This method needs to return the webhook url.

```
public function routeNotificationForZohoCliq(Notification $notification)
{
   return config('services.microsoft_teams.sales_url')
}
```

#### On-Demand Notification Usage
To use on demand notifications you can use the route method on the Notification facade.

```
Notification::route(ZohoCliqChannel::class,null)
->notify(new SubscriptionCreated());
```

## Available Message methods

`to(string $webhookUrl)`: Recipient's webhook url.
`payload(string $summary)`: Payload generated based on the [Zoho docs](https://www.zoho.com/cliq/help/restapi/v2/#Post_Message_Channel).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, use the issues.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [:mehrdadep](https://github.com/mehrdadep)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
