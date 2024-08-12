<?php

/**
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

/**
 * @author Serhiy Lunak
 */
class CancelRetryClientTest extends TestCase
{
    public function testCabBeCreated(): CancelRetryClient
    {
        $client = new CancelRetryClient('gggg7777GGGG7777hhhh8888HHHH88'); // using dummy receipt

        $this->assertInstanceOf(CancelRetryClient::class, $client);

        return $client;
    }

    /**
     * @depends testCabBeCreated
     */
    public function testBuildCurlPostFields(CancelRetryClient $client)
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $receipt = new Receipt($application);

        $curlPostFields = $client->buildCurlPostFields($receipt); // using dummy receipt

        $this->assertEquals([
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
        ], $curlPostFields);
    }

    /**
     * @depends testCabBeCreated
     */
    public function testBuildApiUrl(CancelRetryClient $client)
    {
        $this->assertEquals(
            'https://api.pushover.net/1/receipts/gggg7777GGGG7777hhhh8888HHHH88/cancel.json',
            $client->buildApiUrl(),
        );
    }
}
