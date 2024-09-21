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

namespace Client;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Groups\Group;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\GroupsClient;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class GroupsClientTest extends TestCase
{
    public function testCanBeConstructed(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key

        $client = new GroupsClient($group, GroupsClient::ACTION_RETRIEVE_GROUP);

        $this->assertInstanceOf(GroupsClient::class, $client);
    }

    #[DataProvider('buildApiUrlProvider')]
    public function testBuildApiUrl(string $expected, string $action): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key

        $client = new GroupsClient($group, $action);
        $this->assertSame($expected, $client->buildApiUrl());
    }

    /**
     * @return iterable<array{string, string}>
     */
    public static function buildApiUrlProvider(): iterable
    {
        yield [
            'https://api.pushover.net/1/groups/eeee5555EEEE5555ffff6666FFFF66.json?token=cccc3333CCCC3333dddd4444DDDD44',
            GroupsClient::ACTION_RETRIEVE_GROUP,
        ];

        yield [
            'https://api.pushover.net/1/groups/eeee5555EEEE5555ffff6666FFFF66/add_user.json?token=cccc3333CCCC3333dddd4444DDDD44',
            GroupsClient::ACTION_ADD_USER,
        ];

        yield [
            'https://api.pushover.net/1/groups.json?token=cccc3333CCCC3333dddd4444DDDD44',
            GroupsClient::ACTION_LIST_GROUPS,
        ];
    }

    /**
     * @param array<string, string> $expected
     */
    #[DataProvider('buildCurlPostFieldsProvider')]
    public function testBuildCurlPostFields(array $expected, string $action): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        $client = new GroupsClient($group, $action);

        $this->assertSame(
            $expected,
            $client->buildCurlPostFields($recipient),
        );
    }

    /**
     * @return iterable<array{array<string, string>, string}>
     */
    public static function buildCurlPostFieldsProvider(): iterable
    {
        $base = [
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
            'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
        ];

        foreach ([
            GroupsClient::ACTION_ADD_USER,
            GroupsClient::ACTION_REMOVE_USER,
            GroupsClient::ACTION_ENABLE_USER,
            GroupsClient::ACTION_DISABLE_USER,
        ] as $action) {
            yield [$base, $action];
        }
    }

    #[DataProvider('actionsNeedRecipientProvider')]
    public function testBuildCurlPostFieldsThrowsExceptionWhenRecipientIsNotProvided(string $action): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $group = new Group('eeee5555EEEE5555ffff6666FFFF66', $application); // using dummy group key

        $client = new GroupsClient($group, $action);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Recipient object must be provided for this action.');

        $client->buildCurlPostFields(recipient: null);
    }

    /**
     * @return iterable<list<string>>
     */
    public static function actionsNeedRecipientProvider(): iterable
    {
        yield [GroupsClient::ACTION_ADD_USER];
        yield [GroupsClient::ACTION_REMOVE_USER];
        yield [GroupsClient::ACTION_ENABLE_USER];
        yield [GroupsClient::ACTION_DISABLE_USER];
    }
}
