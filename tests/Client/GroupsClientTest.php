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
use Serhiy\Pushover\Api\Groups\Group;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\GroupsClient;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class GroupsClientTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key

        $client = new GroupsClient($group, GroupsClient::ACTION_RETRIEVE_GROUP);

        $this->assertInstanceOf(GroupsClient::class, $client);
    }

    public function testBuildApiUrl(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key

        // testing various "actions" below

        $client = new GroupsClient($group, GroupsClient::ACTION_RETRIEVE_GROUP);
        $this->assertEquals('https://api.pushover.net/1/groups/eeee5555EEEE5555ffff6666FFFF66.json?token=cccc3333CCCC3333dddd4444DDDD44', $client->buildApiUrl());

        $client = new GroupsClient($group, GroupsClient::ACTION_ADD_USER);
        $this->assertEquals('https://api.pushover.net/1/groups/eeee5555EEEE5555ffff6666FFFF66/add_user.json?token=cccc3333CCCC3333dddd4444DDDD44', $client->buildApiUrl());

	$client = new GroupsClient($group, GroupsClient::ACTION_LIST_GROUPS);
        $this->assertSame('https://api.pushover.net/1/groups.json?token=cccc3333CCCC3333dddd4444DDDD44', $client->buildApiUrl());
        
    }

    public function testBuildCurlPostFields(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        // testing various "actions" below

        $client = new GroupsClient($group, GroupsClient::ACTION_ADD_USER);

        $this->assertEquals(
            [
                'token' => 'cccc3333CCCC3333dddd4444DDDD44',
                'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
            ],
            $client->buildCurlPostFields($recipient),
        );

        $client = new GroupsClient($group, GroupsClient::ACTION_REMOVE_USER);

        $this->assertEquals(
            [
                'token' => 'cccc3333CCCC3333dddd4444DDDD44',
                'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
            ],
            $client->buildCurlPostFields($recipient),
        );

        $client = new GroupsClient($group, GroupsClient::ACTION_ENABLE_USER);

        $this->assertEquals(
            [
                'token' => 'cccc3333CCCC3333dddd4444DDDD44',
                'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
            ],
            $client->buildCurlPostFields($recipient),
        );

        $client = new GroupsClient($group, GroupsClient::ACTION_DISABLE_USER);

        $this->assertEquals(
            [
                'token' => 'cccc3333CCCC3333dddd4444DDDD44',
                'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
            ],
            $client->buildCurlPostFields($recipient),
        );
    }
}
