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

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\ReceiptClient;

/**
 * @author Serhiy Lunak
 */
class ReceiptClientTest extends TestCase
{
    public function testCanBeCreated(): ReceiptClient
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $client = new ReceiptClient($application, 'gggg7777GGGG7777hhhh8888HHHH88'); // using dummy receipt

        $this->assertInstanceOf(ReceiptClient::class, $client);

        return $client;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testBuildApiUrl(ReceiptClient $client): void
    {
        $this->assertEquals(
            'https://api.pushover.net/1/receipts/gggg7777GGGG7777hhhh8888HHHH88.json?token=cccc3333CCCC3333dddd4444DDDD44',
            $client->buildApiUrl(),
        );
    }
}
