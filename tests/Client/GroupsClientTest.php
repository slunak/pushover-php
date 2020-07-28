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

use Serhiy\Pushover\Api\Groups\Group;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\GroupsClient;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class GroupsClientTest extends TestCase
{
    public function testCanBeCreated()
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $group = new Group("uoJCttEFQo8uoZ6REZHMGBjX2pmcdJ", $application); // using dummy group key

        $client = new GroupsClient($group, GroupsClient::ACTION_RETRIEVE_GROUP);

        $this->assertInstanceOf(GroupsClient::class, $client);
    }

    public function testBuildApiUrl()
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $group = new Group("uoJCttEFQo8uoZ6REZHMGBjX2pmcdJ", $application); // using dummy group key

        // testing various "actions" below

        $client = new GroupsClient($group, GroupsClient::ACTION_RETRIEVE_GROUP);
        $this->assertEquals("https://api.pushover.net/1/groups/uoJCttEFQo8uoZ6REZHMGBjX2pmcdJ.json?token=zaGDORePK8gMaC0QOYAMyEEuzJnyUi", $client->buildApiUrl());

        $client = new GroupsClient($group, GroupsClient::ACTION_ADD_USER);
        $this->assertEquals("https://api.pushover.net/1/groups/uoJCttEFQo8uoZ6REZHMGBjX2pmcdJ/add_user.json?token=zaGDORePK8gMaC0QOYAMyEEuzJnyUi", $client->buildApiUrl());
    }

    public function testBuildCurlPostFields()
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $group = new Group("uoJCttEFQo8uoZ6REZHMGBjX2pmcdJ", $application); // using dummy group key
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key

        // testing various "actions" below

        $client = new GroupsClient($group, GroupsClient::ACTION_ADD_USER);

        $this->assertEquals(
            array(
                'token' => 'zaGDORePK8gMaC0QOYAMyEEuzJnyUi',
                'user' => 'uQiRzpo4DXghDmr9QzzfQu27cmVRsG',
            ),
            $client->buildCurlPostFields($recipient)
        );

        $client = new GroupsClient($group, GroupsClient::ACTION_REMOVE_USER);

        $this->assertEquals(
            array(
                'token' => 'zaGDORePK8gMaC0QOYAMyEEuzJnyUi',
                'user' => 'uQiRzpo4DXghDmr9QzzfQu27cmVRsG',
            ),
            $client->buildCurlPostFields($recipient)
        );

        $client = new GroupsClient($group, GroupsClient::ACTION_ENABLE_USER);

        $this->assertEquals(
            array(
                'token' => 'zaGDORePK8gMaC0QOYAMyEEuzJnyUi',
                'user' => 'uQiRzpo4DXghDmr9QzzfQu27cmVRsG',
            ),
            $client->buildCurlPostFields($recipient)
        );

        $client = new GroupsClient($group, GroupsClient::ACTION_DISABLE_USER);

        $this->assertEquals(
            array(
                'token' => 'zaGDORePK8gMaC0QOYAMyEEuzJnyUi',
                'user' => 'uQiRzpo4DXghDmr9QzzfQu27cmVRsG',
            ),
            $client->buildCurlPostFields($recipient)
        );
    }
}
