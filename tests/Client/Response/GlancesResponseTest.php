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
use Serhiy\Pushover\Client\Response\GlancesResponse;

class GlancesResponseTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $successfulCurlResponse = '{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new GlancesResponse($successfulCurlResponse);

        $this->assertInstanceOf(GlancesResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"token":"invalid","errors":["application token is invalid"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new GlancesResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(GlancesResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'application token is invalid'], $response->getErrors());
    }
}
