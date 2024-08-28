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

use Serhiy\Pushover\Api\Message\Attachment;
use Serhiy\Pushover\Api\Message\CustomSound;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Priority;
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\MessageResponse;
use Serhiy\Pushover\Recipient;

/**
 * Complete Notification Example.
 *
 * @author Serhiy Lunak
 */
class CompleteNotificationExample
{
    public function completeNotification(): void
    {
        // instantiate pushover application and recipient of the notification (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // if required, specify devices, otherwise  notification will be sent to all devices
        $recipient->addDevice('android');
        $recipient->addDevice('iphone');

        // compose a message
        $message = new Message('This is a test message', 'This is a title of the message');
        $message->setUrl('https://www.example.com');
        $message->setUrlTitle('Example URL');
        $message->setisHtml(false);
        $message->setTimestamp(new \DateTime('now'));
        $message->setTtl(60 * 60 * 24); // 1 day
        // assign priority to the notification
        $message->setPriority(new Priority(Priority::NORMAL));

        // create notification
        $notification = new Notification($application, $recipient, $message);
        // set notification built-in sound
        $notification->setSound(new Sound(Sound::PUSHOVER));
        // or set notification custom sound
        $notification->setCustomSound(new CustomSound('door_open'));
        // add attachment
        $notification->setAttachment(new Attachment('/path/to/file.jpg', Attachment::MIME_TYPE_JPEG));

        // push notification
        /** @var MessageResponse $response */
        $response = $notification->push();

        // work with response object
        if ($response->isSuccessful()) {
            // ...
        }
    }
}
