<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Example;

use Serhiy\Pushover\Api\Message\Application;
use Serhiy\Pushover\Api\Message\Client;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Recipient;
use Serhiy\Pushover\Api\Message\Response;

/**
 * Response Object Example.
 *
 * @author Serhiy Lunak
 */
class ResponseExample
{
    public function responseExample()
    {
        // instantiate pushover client, application and recipient of the notification (can be injected into service using Dependency Injection)
        $application = new Application("replace_with_pushover_application_api_token");
        $recipient = new Recipient("replace_with_pushover_user_key");
        $client = new Client();

        // compose a message
        $message = new Message("This is a test message", "Simple Notification");

        // create notification
        $notification = new Notification($application, $recipient, $message);

        // push notification
        /**
         * Response object
         *
         * @var Response $response
         */
        $response = $client->push($notification);

        /**
         * Status returned by Pushover API.
         * Either 1 if successful or something other than 1 if unsuccessful.
         *
         * @var int
         */
        $response->getStatus();

        /**
         * Request returned by Pushover API.
         * Randomly-generated unique token that associated with your Pushover request.
         *
         * @var string
         */
        $response->getRequest();

        /**
         * Receipt.
         * When your application sends an emergency-priority notification, API will respond with a receipt value
         * that can be used to get information about whether the notification has been acknowledged.
         * See {@link https://pushover.net/api/receipts} for more information.
         *
         * @var string
         */
        $response->getReceipt();

        /**
         * Errors array.
         * In case of errors, API will return array detailing which parameters were invalid.
         *
         * @var array
         */
        $response->getErrors();

        /**
         * Original curl response.
         * Original, unmodified response from curl request.
         *
         * @var mixed
         */
        $response->getCurlResponse();
    }
}
