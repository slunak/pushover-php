<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Subscription;

use Serhiy\Pushover\Api\Subscription\Subscription;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;

/**
 * @author Serhiy Lunak
 */
class SubscriptionTest extends TestCase
{
    /**
     * @return Subscription
     */
    public function testCanBeCreated(): Subscription
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $subscription = new Subscription($application, "dummy-subscription-aaa111bbb222ccc"); // using dummy subscription code

        $this->assertInstanceOf(Subscription::class, $subscription);

        return $subscription;
    }

    /**
     * @depends testCanBeCreated
     * @param Subscription $subscription
     */
    public function testGetSubscriptionCode(Subscription $subscription)
    {
        $this->assertEquals("dummy-subscription-aaa111bbb222ccc", $subscription->getSubscriptionCode());
    }

    /**
     * @depends testCanBeCreated
     * @param Subscription $subscription
     */
    public function testGetApplication(Subscription $subscription)
    {
        $this->assertInstanceOf(Application::class, $subscription->getApplication());
    }
}
