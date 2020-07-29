<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Response;

use Serhiy\Pushover\Client\Response\GlancesResponse;
use PHPUnit\Framework\TestCase;

class GlancesResponseTest extends TestCase
{
    public function testCanBeCreated()
    {
        $successfulCurlResponse = '{"status":1,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new GlancesResponse($successfulCurlResponse);

        $this->assertInstanceOf(GlancesResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("6g890a90-7943-4at2-b739-4aubi545b508", $response->getRequestToken());

        $unSuccessfulCurlResponse = '{"token":"invalid","errors":["application token is invalid"],"status":0,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new GlancesResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(GlancesResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals("6g890a90-7943-4at2-b739-4aubi545b508", $response->getRequestToken());
        $this->assertEquals(array(0 => "application token is invalid"), $response->getErrors());
    }
}
