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
use Serhiy\Pushover\Client\Response\LicenseResponse;

/**
 * @author Serhiy Lunak
 */
class LicenseResponseTest extends TestCase
{
    public function testCanBeConstructed(): void
    {
        $successfulCurlResponse = '{"credits":5,"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new LicenseResponse($successfulCurlResponse);

        $this->assertInstanceOf(LicenseResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals(5, $response->getCredits());

        $unSuccessfulCurlResponse = '{"token":"is out of available license credits","errors":["application is out of available license credits"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new LicenseResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(LicenseResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'application is out of available license credits'], $response->getErrors());
    }

    public function testGetCredits(): void
    {
        $curlResponse = '{"credits":5,"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new LicenseResponse($curlResponse);

        $this->assertEquals(5, $response->getCredits());
    }
}
