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
use Serhiy\Pushover\Client\Response\MessageResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class HtmlNotificationExample
{
    public function sendHtmlNotification(): void
    {
        // instantiate pushover application and recipient of the notification (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // compose a message
        $message = new Message('This is <b>example</b> of <u>HTML</u> styled <i>message</i>.', 'HTML Notification');
        // set message to html, see https://pushover.net/api#html for details
        $message->setIsHtml(true);

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
