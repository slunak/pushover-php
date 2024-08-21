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
use Serhiy\Pushover\Client\Response\RemoveUserFromGroupResponse;

/**
 * @author Serhiy Lunak
 */
class RemoveUserFromGroupResponseTest extends TestCase
{
    public function testCenBeCreated(): void
    {
        $successfulCurlResponse = '{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new RemoveUserFromGroupResponse($successfulCurlResponse);

        $this->assertInstanceOf(RemoveUserFromGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"user":"invalid","errors":["user is not a member of this group"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new RemoveUserFromGroupResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(RemoveUserFromGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'user is not a member of this group'], $response->getErrors());
    }
}
