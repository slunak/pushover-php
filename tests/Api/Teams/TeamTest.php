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

namespace Api\Teams;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Teams\Team;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class TeamTest extends TestCase
{
    public function testCanBeConstructed(): Team
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $this->assertInstanceOf(Team::class, $team);

        return $team;
    }

    public function testCannotBeConstructedWithInvalidToken(): void
    {
        $token = 'Lorem ipsum dolor sit amet';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'Team API tokens are case-sensitive, 30 characters long, and may contain the character set [A-Za-z0-9]. "%s" given with "%s" characters.',
            $token,
            \strlen($token),
        ));

        new Team($token);
    }

    public function testGetToken(): void
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $this->assertSame('cccc3333CCCC3333dddd4444DDDD44', $team->getToken());
    }

    public function testGetNameReturnsNullByDefault(): void
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $this->assertNull($team->getName());
    }

    public function testGetUsersReturnsEmptyArrayByDefault(): void
    {
        $team = new Team('cccc3333CCCC3333dddd4444DDDD44');

        $this->assertSame([], $team->getUsers());
    }
}
