<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\UserGroupValidationResponse;
use Serhiy\Pushover\Client\UserGroupValidationClient;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class UserGroupValidationClientTest extends TestCase
{
    public function testCanBeCreated()
    {
        $client = new UserGroupValidationClient();

        $this->assertInstanceOf(UserGroupValidationClient::class, $client);

        return $client;
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationClient $client
     */
    public function testBuildCurlPostFields(UserGroupValidationClient $client)
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $curlPostFields = $client->buildCurlPostFields($application, $recipient);

        $this->assertEquals(array(
            "token" => "zaGDORePK8gMaC0QOYAMyEEuzJnyUi",
            "user" => "uQiRzpo4DXghDmr9QzzfQu27cmVRsG",
        ), $curlPostFields);
    }

    /**
     * @depends testCanBeCreated
     * @param UserGroupValidationClient $client
     */
    public function testBuildApiUrl(UserGroupValidationClient $client)
    {
        $this->assertEquals("https://api.pushover.net/1/users/validate.json", $client->buildApiUrl());
    }

    public function testSend()
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $client = new UserGroupValidationClient();
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($application, $recipient));

        $curlResponse = Curl::do($request);

        $response = new UserGroupValidationResponse($curlResponse);

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
    }
}
