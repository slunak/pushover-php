# Pushover PHP API Wrapper

[![Build Status](https://travis-ci.org/slunak/pushover-php.svg?branch=master)](https://travis-ci.org/slunak/pushover-php)
[![Latest Stable Version](https://poser.pugx.org/serhiy/pushover/v)](https://packagist.org/packages/serhiy/pushover)
[![Total Downloads](https://poser.pugx.org/serhiy/pushover/downloads)](https://packagist.org/packages/serhiy/pushover)
[![License](https://poser.pugx.org/serhiy/pushover/license)](LICENSE)

Light, simple and fast, yet comprehensive wrapper for the [Pushover](https://pushover.net/) API.

### Features
- Message API
  - Image attachment
  - User's device name(s)
  - Message's title
  - HTML messages
  - Supplementary URL and its title
  - Notification priority
  - Notification sound
  - Message time
- User/Group Validation API ([Example](Example/UserGroupValidationExample.php))
  - Validation by user or group key
  - Validation by user and device
- Receipt API ([Example](Example/ReceiptExample.php))
  - Query emergency priority receipt
  - Cancel emergency priority retry
- Groups API ([Example](Example/GroupsExample.php))
  - Retrieve information about the group
  - Add / Remove users
  - Enable / Disable users
  - Rename the group
- Glances API ([Example](Example/GlancesExample.php))
  - Title
  - Text
  - Subtext
  - Count
  - Percent
- Licensing API ([Example](Example/LicensingExample.php))
  - Check remaining credits
  - Assign license (not tested)
- Subscription API ([Example](Example/SubscriptionExample.php))
  - User Key Migration 

*Note: Project is in constant development; update to newer versions with caution.*

## Getting Started

These instructions will get you a copy of the project up and running.

### Installing

```
composer require "serhiy/pushover"
```

### Requirements

I aim to keep the project as simple as possible. All you need to run it is a PHP supported version,
plus its curl and json extensions. See below the `require` section of project's composer.json file:

```json
{
    "require": {
        "php": "^7.1",
        "ext-curl": "*",
        "ext-json": "*"
    }
}
```

## Pushing Messages

*Note: For more code examples, see [Example](Example) folder in the root of the project. You may also generate and see code documentation.*

Instantiate pushover application and recipient of the notification:

```php
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

$application = new Application("replace_with_pushover_application_api_token");
$recipient = new Recipient("replace_with_pushover_user_key");
```

Or use Dependency Injection to inject them into the services of your app.

Compose a message:

```php
use Serhiy\Pushover\Api\Message\Message;

$message = new Message("This is a test message", "This is a title of the message");
```

Create notification:

```php
use Serhiy\Pushover\Api\Message\Notification;

$notification = new Notification($application, $recipient, $message);
```
        
Push it:

```php
/** @var \Serhiy\Pushover\Client\Response\MessageResponse $response */
$response = $notification->push();
```

## Working with response

*Note: For complete example refer to [ResponseExample.php](Example/ResponseExample.php)*

Client returns Response object. Checking if the message was accepted is easy:

```php
if ($response->isSuccessful()) {
    // ...
}
```

One can get status and token returned by Pushover:

```php
$response->getRequestStatus();
$response->getRequestToken();
```

Or even unmodified json response from the API (json_decode into an array if needed):

```php
$response->getCurlResponse();
``` 

Response also contains original Request object:

```php
/** @var \Serhiy\Pushover\Client\Request\Request $request */
$request = $response->getRequest();
```

Request contains array for CURLOPT_POSTFIELDS curl argument and full API URL.
        
```php
$request->getCurlPostFields();
$request->getApiUrl();
``` 

## Contributing

Contributions are very welcome. If you would like to add functionality, before starting your work,
please open an issue to discuss the feature you would like to work on.

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

There are many PHP wrappers for Pushover API. However, most of them seem abandoned, missing features
or require extra libraries to work. Nevertheless, many of them inspired me to work on this project.
