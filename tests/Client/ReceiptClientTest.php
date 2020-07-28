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
use Serhiy\Pushover\Client\ReceiptClient;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\ReceiptResponse;

/**
 * @author Serhiy Lunak
 */
class ReceiptClientTest extends TestCase
{
    /**
     * @return ReceiptClient
     */
    public function testCanBeCreated(): ReceiptClient
    {
        $application = new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $client = new ReceiptClient($application, "sraw8swp2qh9bp6o4n7bw6o6cic94j"); // using dummy receipt

        $this->assertInstanceOf(ReceiptClient::class, $client);

        return $client;
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptClient $client
     */
    public function testBuildApiUrl(ReceiptClient $client)
    {
        $this->assertEquals(
            "https://api.pushover.net/1/receipts/sraw8swp2qh9bp6o4n7bw6o6cic94j.json?token=azGDORePK8gMaC0QOYAMyEEuzJnyUi",
            $client->buildApiUrl()
        );
    }

    /**
     * @depends testCanBeCreated
     * @param ReceiptClient $client
     */
    public function testSend(ReceiptClient $client)
    {
        $request = new Request($client->buildApiUrl(), Request::GET);

        $curlResponse = Curl::do($request);

        $response = new ReceiptResponse($curlResponse);

        $this->assertInstanceOf(ReceiptResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInstanceOf(Request::class, $request);
    }
}