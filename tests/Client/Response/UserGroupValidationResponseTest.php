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
        $curlResponse = '{"status":1,"group":0,"devices":["iphone"],"licenses":["Android","iOS"],"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new UserGroupValidationResponse($curlResponse);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);

        $response->setDevices(array("iphone", "pixel"));
        $response->setLicenses(array("ios", "android"));

        return $response;
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationResponse $response
     */
    public function testSetLicenses(UserGroupValidationResponse $response)
    {
        $response->setLicenses(array("ios", "android"));

        $this->assertEquals(array("ios", "android"), $response->getLicenses());
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationResponse $response
     */
    public function testGetLicenses(UserGroupValidationResponse $response)
    {
        $this->assertEquals(array("ios", "android"), $response->getLicenses());
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationResponse $response
     */
    public function testSetDevices(UserGroupValidationResponse $response)
    {
        $response->setDevices(array("iphone", "pixel"));

        $this->assertEquals(array("iphone", "pixel"), $response->getDevices());
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationResponse $response
     */
    public function testGetDevices(UserGroupValidationResponse $response)
    {
        $this->assertEquals(array("iphone", "pixel"), $response->getDevices());
    }
}
