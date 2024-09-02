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
use Serhiy\Pushover\Api\Licensing\License;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\AssignLicenseClient;
use Serhiy\Pushover\Exception\LogicException;
use Serhiy\Pushover\Recipient;

class AssignLicenseClientTest extends TestCase
{
    public function testBuildApiUrl(): void
    {
        $client = new AssignLicenseClient();
        $this->assertInstanceOf(AssignLicenseClient::class, $client);
        $this->assertSame('https://api.pushover.net/1/licenses/assign.json', $client->buildApiUrl());
    }

    public function testBuildCurlPostFields(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $license = new License($application);
        $email = 'dummy@email.com';

        $license->setRecipient($recipient);
        $license->setEmail($email);
        $license->setOs(License::OS_ANDROID);

        $client = new AssignLicenseClient();

        $curlPostFields = [
            'token' => 'cccc3333CCCC3333dddd4444DDDD44',
            'user' => 'aaaa1111AAAA1111bbbb2222BBBB22',
            'email' => 'dummy@email.com',
            'os' => 'Android',
        ];

        $this->assertSame($curlPostFields, $client->buildCurlPostFields($license));

        $license->setRecipient(null);
        $license->setEmail(null);

        $this->expectException(LogicException::class);
        $client->buildCurlPostFields($license);
    }
}
