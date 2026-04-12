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

namespace Client\Response;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Response\AddUserToTeamResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class AddUserToTeamResponseTest extends TestCase
{
    public function testSuccessfulResponse(): void
    {
        $response = new AddUserToTeamResponse('{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(AddUserToTeamResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
    }

    public function testUnsuccessfulResponse(): void
    {
        $response = new AddUserToTeamResponse('{"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc","errors":["email is invalid"]}');

        $this->assertInstanceOf(AddUserToTeamResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'email is invalid'], $response->getErrors());
    }
}
