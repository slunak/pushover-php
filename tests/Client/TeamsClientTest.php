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
use Serhiy\Pushover\Api\Teams\Team;
use Serhiy\Pushover\Api\Teams\User;
use Serhiy\Pushover\Client\TeamsClient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class TeamsClientTest extends TestCase
{
    public function testCanBeConstructed(): void
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $client = new TeamsClient($team, TeamsClient::ACTION_RETRIEVE_TEAM);

        $this->assertInstanceOf(TeamsClient::class, $client);
    }

    #[DataProvider('buildApiUrlProvider')]
    public function testBuildApiUrl(string $expected, string $action): void
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $client = new TeamsClient($team, $action);

        $this->assertSame($expected, $client->buildApiUrl());
    }

    /**
     * @return iterable<array{string, string}>
     */
    public static function buildApiUrlProvider(): iterable
    {
        yield [
            'https://api.pushover.net/1/teams.json?token=cccc3333CCCC3333dddd4444DDDD44',
            TeamsClient::ACTION_RETRIEVE_TEAM,
        ];

        yield [
            'https://api.pushover.net/1/teams/add_user.json',
            TeamsClient::ACTION_ADD_USER,
        ];

        yield [
            'https://api.pushover.net/1/teams/remove_user.json',
            TeamsClient::ACTION_REMOVE_USER,
        ];
    }

    /**
     * @param array<string, string> $expected
     */
    #[DataProvider('buildCurlPostFieldsProvider')]
    public function testBuildCurlPostFields(array $expected, User $user, string $action): void
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $client = new TeamsClient($team, $action);

        $this->assertSame($expected, $client->buildCurlPostFields($user));
    }

    /**
     * @return iterable<array{array<string, string>, User, string}>
     */
    public static function buildCurlPostFieldsProvider(): iterable
    {
        $addUser = new User('[email protected]');
        $addUser->setName('Team User');
        $addUser->setPassword('secret');
        $addUser->setInstant(true);
        $addUser->setIsAdministrator(true);
        $addUser->setGroup('Operations');

        yield [
            [
                'token' => 'cccc3333CCCC3333dddd4444DDDD44',
                'email' => '[email protected]',
                'name' => 'Team User',
                'password' => 'secret',
                'instant' => 'true',
                'admin' => 'true',
                'group' => 'Operations',
            ],
            $addUser,
            TeamsClient::ACTION_ADD_USER,
        ];

        yield [
            [
                'token' => 'cccc3333CCCC3333dddd4444DDDD44',
                'email' => '[email protected]',
            ],
            new User('[email protected]'),
            TeamsClient::ACTION_REMOVE_USER,
        ];
    }

    #[DataProvider('actionsNeedUserProvider')]
    public function testBuildCurlPostFieldsThrowsExceptionWhenUserIsNotProvided(string $action): void
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $client = new TeamsClient($team, $action);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('User object must be provided for this action.');

        $client->buildCurlPostFields(user: null);
    }

    /**
     * @return iterable<list<string>>
     */
    public static function actionsNeedUserProvider(): iterable
    {
        yield [TeamsClient::ACTION_ADD_USER];
        yield [TeamsClient::ACTION_REMOVE_USER];
    }
}
