<?php

declare(strict_types=1);

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Example;

use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\MessageResponse;
use Serhiy\Pushover\Recipient;

/**
 * Response Object Example.
 *
 * @author Serhiy Lunak
 */
final class ResponseExample
{
    public function responseExample(): void
    {
        // instantiate pushover application and recipient of the notification (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // compose a message
        $message = new Message('This is a test message', 'Simple Notification');

        // create notification
        $notification = new Notification($application, $recipient, $message);

        // push notification
        /**
         * Response object.
         *
         * @var MessageResponse $response
         */
        $response = $notification->push();

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
         * @var string[]
         */
        $response->getErrors();

        /**
         * Original curl response.
         * Original, unmodified response from curl request.
         *
         * @var string
         */
        $response->getCurlResponse();

        /**
         * Object Containing request.
         * It contains array for CURLOPT_POSTFIELDS curl argument and API URL.
         *
         * @var Request
         */
        $request = $response->getRequest();
        $request->getCurlPostFields(); // array, array for CURLOPT_POSTFIELDS curl argument
        $request->getApiUrl(); // string, API URL
    }
}
