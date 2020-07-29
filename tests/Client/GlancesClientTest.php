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

use Serhiy\Pushover\Api\Glances\Glance;
use Serhiy\Pushover\Api\Glances\GlanceDataFields;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\GlancesClient;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Recipient;

class GlancesClientTest extends TestCase
{
    public function testCanBeCreated()
    {
        $client = new GlancesClient();

        $this->assertInstanceOf(GlancesClient::class, $client);
    }

    public function testBuildApiUrl()
    {
        $client = new GlancesClient();

        $this->assertEquals("https://api.pushover.net/1/glances.json", $client->buildApiUrl());
    }

    public function testBuildCurlPostFields()
    {
        $client = new GlancesClient();

        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $glanceDataFields = new GlanceDataFields();

        $glance = new Glance($application, $glanceDataFields);
        $glance->setRecipient($recipient);
        $glance->getGlanceDataFields()->setTitle("This is test title");

        $curlPostFields = array(
            "token" => "zaGDORePK8gMaC0QOYAMyEEuzJnyUi",
            "user" => "uQiRzpo4DXghDmr9QzzfQu27cmVRsG",
            "title" => "This is test title",
        );

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($glance));
    }
}
