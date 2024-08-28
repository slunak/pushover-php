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

use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Api\Subscription\Subscription;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\SubscriptionResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
final class SubscriptionExample
{
    public function subscriptionExample(): void
    {
        // instantiate pushover application and recipient (can be injected into service using Dependency Injection)
        $application = new Application('replace_with_pushover_application_api_token');
        $recipient = new Recipient('replace_with_pushover_user_key');

        // create subscription (can be injected into service using Dependency Injection)
        $subscription = new Subscription($application, 'replace_with_subscription_user_code');

        // migrate from Pushover user keys to subscription keys
        /** @var SubscriptionResponse $response */
        $response = $subscription->migrate($recipient);

        // migrate and specify optional user's device name that the subscription should be limited to
        $recipient->addDevice('android');
        /** @var SubscriptionResponse $response */
        $response = $subscription->migrate($recipient);

        // you may also specify optional preferred default sound
        /** @var SubscriptionResponse $response */
        $response = $subscription->migrate($recipient, new Sound(Sound::PUSHOVER));

        // or loop over recipients or emails
        $recipients = []; // array of Recipient objects

        foreach ($recipients as $recipient) {
            $response = $subscription->migrate($recipient);
        }

        // work with response
        if ($response->isSuccessful()) {
            var_dump($response->getSubscribedUserKey());
        }
    }
}
