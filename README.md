# Pushover PHP API Wrapper

[![Build Status](https://travis-ci.org/slunak/pushover-php.svg?branch=master)](https://travis-ci.org/slunak/pushover-php)
[![Latest Stable Version](https://poser.pugx.org/serhiy/pushover/v)](https://packagist.org/packages/serhiy/pushover)
[![Total Downloads](https://poser.pugx.org/serhiy/pushover/downloads)](https://packagist.org/packages/serhiy/pushover)
[![License](https://poser.pugx.org/serhiy/pushover/license)](LICENSE)

Light, simple and fast wrapper for the Pushover API.

## Getting Started

These instructions will get you a copy of the project up and running.

### Requirements

I aim to keep the project as simple as possible. All you need to run it is a PHP supported version,
plus its curl and json extensions. See below the `require` section of composer.json file:

```json
{
    "require": {
        "php": "^7.1",
        "ext-curl": "*",
        "ext-json": "*"
    }
}
```

### Installing

```
composer require "serhiy/pushover"
```

## Pushing Messages

Instantiate the client, application and recipient of the notification:

```php
$client = new Client();
$application = new Application("replace_with_pushover_application_api_token");
$recipient = new Recipient("replace_with_pushover_user_key");
```

Or use Dependency Injection to inject them into the services of your app.

Compose a message:

```php
$message = new Message("This is a test message", "This is a title of the message");
```

Create notification:

```php
$notification = new Notification($application, $recipient, $message);
```
        
And push it:

```php
/** @var Response $response */
$response = $client->push($notification);
```

Client returns Response object which contains the status, request ID, receipt if any and errors array.

```php
var_dump($response);
``` 

For more code examples, see `Example` folder in the root of the project. You may also generate and see code documentation.

## Contributing

Contributions are very welcome. If you would like to add functionality, before starting your work,
please open an issue to discuss the feature you would like to work on.

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

There are many PHP wrappers for Pushover API. However, most of them seem abandoned, missing features
or require extra libraries to work. Nevertheless, many of them inspired me to work on this project.
