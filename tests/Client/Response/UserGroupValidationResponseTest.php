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
use Serhiy\Pushover\Client\Response\UserGroupValidationResponse;

/**
 * @author Serhiy Lunak
 */
class UserGroupValidationResponseTest extends TestCase
{
    public function testCanBeCreated(): UserGroupValidationResponse
    {
        $unSuccessfulCurlResponse = '{"user":"invalid","errors":["user key is invalid"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new UserGroupValidationResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'user key is invalid'], $response->getErrors());

        $successfulCurlResponse = '{"status":1,"group":0,"devices":["test-device-1", "test-device-2"],"licenses":["Android","iOS"],"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new UserGroupValidationResponse($successfulCurlResponse);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetLicenses(UserGroupValidationResponse $response): void
    {
        $this->assertEquals(['Android', 'iOS'], $response->getLicenses());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetDevices(UserGroupValidationResponse $response): void
    {
        $this->assertEquals(['test-device-1', 'test-device-2'], $response->getDevices());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetIsGroup(UserGroupValidationResponse $response): void
    {
        $this->assertFalse($response->isGroup());
    }
}
