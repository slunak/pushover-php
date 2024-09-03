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
use Serhiy\Pushover\Client\Response\EnableUserInGroupResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class EnableUserInGroupResponseTest extends TestCase
{
    public function testCanBeCreatedWithSuccessfulCurlResponse(): void
    {
        $response = new EnableUserInGroupResponse('{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(EnableUserInGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
    }

    public function testCanBeCreatedWithUnsuccessfulCurlResponse(): void
    {
        $response = new EnableUserInGroupResponse('{"user":"invalid","errors":["user is not a member of this group"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(EnableUserInGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'user is not a member of this group'], $response->getErrors());
    }
}
