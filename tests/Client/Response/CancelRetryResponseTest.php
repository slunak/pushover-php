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

use Serhiy\Pushover\Client\Response\CancelRetryResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Serhiy Lunak
 */
class CancelRetryResponseTest extends TestCase
{
    public function testCenBeCreated(): void
    {
        $successfulCurlResponse = '{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new CancelRetryResponse($successfulCurlResponse);

        $this->assertInstanceOf(CancelRetryResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"receipt":"not found","errors":["receipt not found; may be invalid or expired"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new CancelRetryResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(CancelRetryResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'receipt not found; may be invalid or expired'], $response->getErrors());
    }
}
