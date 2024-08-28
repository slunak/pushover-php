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
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\MessageResponse;
use Serhiy\Pushover\Recipient;

/**
 * Emergency Notification Example.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class EmergencyNotificationExample
{
    public function sendEmergencyNotification(): void
    {
        // instantiate pushover application and recipient of the notification (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // compose a message
        $message = new Message('This is a test message', 'Simple Notification');
        // set priority by creating new Priority object with priority value, retry and expire parameters.
        // Retry and expire parameters required only with emergency priority
        // See https://pushover.net/api#priority for details.
        $message->setPriority(new Priority(Priority::EMERGENCY, 30, 600));

        // create notification
        $notification = new Notification($application, $recipient, $message);

        // push notification
        /** @var MessageResponse $response */
        $response = $notification->push();

        // work with response object
        if ($response->isSuccessful()) {
            // ...
        }
    }
}
