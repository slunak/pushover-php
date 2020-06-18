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
use Serhiy\Pushover\Api\Message\Request;
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
         * True if request was successful, false otherwise. Reflects $requestStatus property.
         *
         * @var bool
         */
        $response->isSuccessful();

        /**
         * Status returned by Pushover API.
         * Either 1 if successful or something other than 1 if unsuccessful.
         * Reflects $isSuccessful property.
         *
         * @var int
         */
        $response->getRequestStatus();

        /**
         * Request returned by Pushover API.
         * Randomly-generated unique token that associated with your Pushover request.
         *
         * @var string
         */
        $response->getRequestToken();

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

        /**
         * Object Containing request.
         * It contains notification object, which in turn contains application, recipient and message objects.
         * It also contains array for CURLOPT_POSTFIELDS curl argument and API URL.
         *
         * @var Request
         */
        $request = $response->getRequest();
        $request->getNotification(); // Notification object
        $request->getNotification()->getApplication();
        $request->getNotification()->getRecipient();
        $request->getNotification()->getMessage();
        $request->getCurlPostFields(); // array, array for CURLOPT_POSTFIELDS curl argument
        $request->getFullUrl(); // string, API URL
    }
}
