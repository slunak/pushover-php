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

use Serhiy\Pushover\Api\Receipts\Receipt;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\CancelRetryClient;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\CancelRetryResponse;

/**
 * @author Serhiy Lunak
 */
class CancelRetryClientTest extends TestCase
{
    /**
     * @return CancelRetryClient
     */
    public function testCabBeCreated(): CancelRetryClient
    {
        $client = new CancelRetryClient("sraw8swp2qh9bp6o4n7bw6o6cic94j"); // using dummy receipt

        $this->assertInstanceOf(CancelRetryClient::class, $client);

        return $client;
    }

    /**
     * @depends testCabBeCreated
     * @param CancelRetryClient $client
     */
    public function testBuildCurlPostFields(CancelRetryClient $client)
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $receipt = new Receipt($application);

        $curlPostFields = $client->buildCurlPostFields($receipt); // using dummy receipt

        $this->assertEquals(array(
            "token" => "zaGDORePK8gMaC0QOYAMyEEuzJnyUi",
        ), $curlPostFields);
    }

    /**
     * @depends testCabBeCreated
     * @param CancelRetryClient $client
     */
    public function testBuildApiUrl(CancelRetryClient $client)
    {
        $this->assertEquals(
            "https://api.pushover.net/1/receipts/sraw8swp2qh9bp6o4n7bw6o6cic94j/cancel.json",
            $client->buildApiUrl()
        );
    }

    /**
     * @depends testCabBeCreated
     * @param CancelRetryClient $client
     */
    public function testSend(CancelRetryClient $client)
    {
        $request = new Request($client->buildApiUrl(), Request::POST);

        $curlResponse = Curl::do($request);

        $response = new CancelRetryResponse($curlResponse);

        $this->assertInstanceOf(CancelRetryResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInstanceOf(Request::class, $request);
    }
}
