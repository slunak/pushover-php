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

use Serhiy\Pushover\Client\Response\UserGroupValidationResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Serhiy Lunak
 */
class UserGroupValidationResponseTest extends TestCase
{
    /**
     * @return UserGroupValidationResponse
     */
    public function testCanBeCreated(): UserGroupValidationResponse
    {
        $unSuccessfulCurlResponse = '{"user":"invalid","errors":["user key is invalid"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new UserGroupValidationResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());
        $this->assertEquals(array(0 => "user key is invalid"), $response->getErrors());

        $successfulCurlResponse = '{"status":1,"group":0,"devices":["test-device-1", "test-device-2"],"licenses":["Android","iOS"],"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new UserGroupValidationResponse($successfulCurlResponse);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("aaaaaaaa-1111-bbbb-2222-cccccccccccc", $response->getRequestToken());

        return $response;
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationResponse $response
     */
    public function testGetLicenses(UserGroupValidationResponse $response)
    {
        $this->assertEquals(array("Android","iOS"), $response->getLicenses());
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationResponse $response
     */
    public function testGetDevices(UserGroupValidationResponse $response)
    {
        $this->assertEquals(array("test-device-1", "test-device-2"), $response->getDevices());
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationResponse $response
     */
    public function testGetIsGroup(UserGroupValidationResponse $response)
    {
        $this->assertFalse($response->isGroup());
    }
}
