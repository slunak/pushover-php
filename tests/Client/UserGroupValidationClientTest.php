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
     */
    public function testBuildCurlPostFields(UserGroupValidationClient $client)
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $curlPostFields = $client->buildCurlPostFields($application, $recipient);

        $this->assertEquals([
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
            'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
        ], $curlPostFields);
    }

    /**
     * @depends testCanBeCreated
     */
    public function testBuildApiUrl(UserGroupValidationClient $client)
    {
        $this->assertEquals('https://api.pushover.net/1/users/validate.json', $client->buildApiUrl());
    }
}
