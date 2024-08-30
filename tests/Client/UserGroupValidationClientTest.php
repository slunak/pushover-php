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

namespace Client;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\UserGroupValidationClient;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class UserGroupValidationClientTest extends TestCase
{
    public function testCanBeConstructed(): UserGroupValidationClient
    {
        $client = new UserGroupValidationClient();

        $this->assertInstanceOf(UserGroupValidationClient::class, $client);

        return $client;
    }

    #[\PHPUnit\Framework\Attributes\Depends('testCanBeConstructed')]
    public function testBuildCurlPostFields(UserGroupValidationClient $client): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $curlPostFields = $client->buildCurlPostFields($application, $recipient);

        $this->assertSame([
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
            'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
        ], $curlPostFields);
    }

    #[\PHPUnit\Framework\Attributes\Depends('testCanBeConstructed')]
    public function testBuildApiUrl(UserGroupValidationClient $client): void
    {
        $this->assertSame('https://api.pushover.net/1/users/validate.json', $client->buildApiUrl());
    }
}
