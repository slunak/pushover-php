<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Response;

use Serhiy\Pushover\Client\Response\RenameGroupResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Serhiy Lunak
 */
class RenameGroupResponseTest extends TestCase
{
    public function testCenBeCreated(): void
    {
        $successfulCurlResponse = '{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new RenameGroupResponse($successfulCurlResponse);

        $this->assertInstanceOf(RenameGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"group":"not found","errors":["group not found or you are not authorized to edit it"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new RenameGroupResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(RenameGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'group not found or you are not authorized to edit it'], $response->getErrors());
    }
}
