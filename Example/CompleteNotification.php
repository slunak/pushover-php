<?php

/*
 * This file is part of the Pushover package.
 *
 *  (c) Serhiy Lunak <https://github.com/slunak>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Example;

use Serhiy\Pushover\Api\Message\Application;
use Serhiy\Pushover\Api\Message\Client;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\Api\Message\Recipient;
use Serhiy\Pushover\Api\Message\Response;

/**
 * Complete Notification Example.
 *
 * @author Serhiy Lunak
 */
class CompleteNotification
{
    public function completeNotification()
    {
        // instantiate pushover client, application and recipient of the notification (can be injected into service using Dependency Injection)
        $application = new Application("replace_with_pushover_application_api_token");
        $recipient = new Recipient("replace_with_pushover_user_key");
        $client = new Client();

        // if required, specify devices, otherwise  notification will be sent to all devices
        $recipient->addDevice("android");
        $recipient->addDevice("iphone");

        // compose a message
        $message = new Message("This is a test message", "This is a title of the message");
        $message->setUrl("https://www.example.com");
        $message->setUrlTitle("Example URL");
        $message->setisHtml(false);
        $message->setTimestamp(new \DateTime('now'));
        // assign priority to the notification
        $message->setPriority(new Priority(Priority::NORMAL));

        // create notification
        $notification = new Notification($application, $recipient, $message);

        // push notification
        /** @var Response $response */
        $response = $client->push($notification);

        // work with response object
        var_dump($response);
    }
}
