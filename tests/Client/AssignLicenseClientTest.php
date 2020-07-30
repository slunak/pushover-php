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

use Serhiy\Pushover\Api\Licensing\License;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\AssignLicenseClient;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Exception\LogicException;
use Serhiy\Pushover\Recipient;

class AssignLicenseClientTest extends TestCase
{
    public function testBuildApiUrl()
    {
        $client = new AssignLicenseClient();
        $this->assertInstanceOf(AssignLicenseClient::class, $client);
        $this->assertEquals("https://api.pushover.net/1/licenses/assign.json", $client->buildApiUrl());
    }

    public function testBuildCurlPostFields()
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $license = new License($application);
        $email = 'dummy@email.com';

        $license->setRecipient($recipient);
        $license->setEmail($email);
        $license->setOs(License::OS_ANDROID);

        $client = new AssignLicenseClient();

        $curlPostFields = array(
            "token" => "zaGDORePK8gMaC0QOYAMyEEuzJnyUi",
            "user" => "uQiRzpo4DXghDmr9QzzfQu27cmVRsG",
            "email" => "dummy@email.com",
            "os" => "Android",
        );

        $this->assertEquals($curlPostFields, $client->buildCurlPostFields($license));

        $license->setRecipient(null);
        $license->setEmail(null);

        $this->expectException(LogicException::class);
        $client->buildCurlPostFields($license);
    }
}
