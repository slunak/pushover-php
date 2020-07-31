<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client;

use Serhiy\Pushover\Api\Message\Sound;
use Serhiy\Pushover\Api\Subscription\Subscription;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\SubscriptionClient;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Recipient;

class SubscriptionClientTest extends TestCase
{
    public function testCanBeCreated()
    {
        $client = new SubscriptionClient();

        $this->assertInstanceOf(SubscriptionClient::class, $client);
    }

    public function testBuildCurlPostFields()
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $subscription = new Subscription($application, "dummy-subscription-aaa111bbb222ccc"); // using dummy subscription code

        $client = new SubscriptionClient();

        // only required parameters
        $curlPostFields = array(
            "token" => "zaGDORePK8gMaC0QOYAMyEEuzJnyUi",
            "subscription" => "dummy-subscription-aaa111bbb222ccc",
            "user" => "uQiRzpo4DXghDmr9QzzfQu27cmVRsG",
        );

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($subscription, $recipient));

        // add recipient device
        $recipient->addDevice("android");

        $curlPostFields = array(
            "token" => "zaGDORePK8gMaC0QOYAMyEEuzJnyUi",
            "subscription" => "dummy-subscription-aaa111bbb222ccc",
            "user" => "uQiRzpo4DXghDmr9QzzfQu27cmVRsG",
            "device_name" => "android",
        );

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($subscription, $recipient));

        // add sound
        $curlPostFields = array(
            "token" => "zaGDORePK8gMaC0QOYAMyEEuzJnyUi",
            "subscription" => "dummy-subscription-aaa111bbb222ccc",
            "user" => "uQiRzpo4DXghDmr9QzzfQu27cmVRsG",
            "device_name" => "android",
            "sound" => "pushover",
        );

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($subscription, $recipient, new Sound(Sound::PUSHOVER)));
    }

    public function testBuildApiUrl()
    {
        $client = new SubscriptionClient();

        $this->assertEquals("https://api.pushover.net/1/subscriptions/migrate.json", $client->buildApiUrl());
    }
}
