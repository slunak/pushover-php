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

namespace Api\Subscription;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Subscription\Subscription;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\SubscriptionResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class SubscriptionTest extends TestCase
{
    public function testCanBeConstructed(): Subscription
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $subscription = new Subscription($application, 'dummy-subscription-aaa111bbb222ccc'); // using dummy subscription code

        $this->assertInstanceOf(Subscription::class, $subscription);

        return $subscription;
    }

    #[\PHPUnit\Framework\Attributes\Depends('testCanBeConstructed')]
    public function testGetSubscriptionCode(Subscription $subscription): void
    {
        $this->assertSame('dummy-subscription-aaa111bbb222ccc', $subscription->getSubscriptionCode());
    }

    #[\PHPUnit\Framework\Attributes\Depends('testCanBeConstructed')]
    public function testGetApplication(Subscription $subscription): void
    {
        $this->assertInstanceOf(Application::class, $subscription->getApplication());
    }

    #[\PHPUnit\Framework\Attributes\Group('Integration')]
    public function testMigrate(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $subscription = new Subscription($application, 'dummy-subscription-aaa111bbb222ccc');
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        $recipient->addDevice('test-device-1');

        $response = $subscription->migrate($recipient);

        $this->assertInstanceOf(SubscriptionResponse::class, $response);
    }
}
