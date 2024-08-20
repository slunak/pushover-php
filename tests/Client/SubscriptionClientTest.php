<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Api\Subscription\Subscription;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\SubscriptionClient;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class SubscriptionClientTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $client = new SubscriptionClient();

        $this->assertInstanceOf(SubscriptionClient::class, $client);
    }

    public function testBuildCurlPostFields(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $subscription = new Subscription($application, 'dummy-subscription-aaa111bbb222ccc'); // using dummy subscription code

        $client = new SubscriptionClient();

        // only required parameters
        $curlPostFields = [
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
            'subscription' => 'dummy-subscription-aaa111bbb222ccc',
            'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
        ];

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($subscription, $recipient));

        // add recipient device
        $recipient->addDevice('test-device-1');

        $curlPostFields = [
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
            'subscription' => 'dummy-subscription-aaa111bbb222ccc',
            'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
            'device_name' => 'test-device-1',
        ];

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($subscription, $recipient));

        // add sound
        $curlPostFields = [
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
            'subscription' => 'dummy-subscription-aaa111bbb222ccc',
            'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
            'device_name' => 'test-device-1',
            'sound' => 'pushover',
        ];

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($subscription, $recipient, new Sound(Sound::PUSHOVER)));
    }

    public function testBuildApiUrl(): void
    {
        $client = new SubscriptionClient();

        $this->assertEquals('https://api.pushover.net/1/subscriptions/migrate.json', $client->buildApiUrl());
    }
}
