<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Licensing;

use Serhiy\Pushover\Api\Licensing\License;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

class LicenseTest extends TestCase
{
    /**
     * @return License
     */
    public function testCanBeCreated(): License
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $license = new License($application);

        $this->assertInstanceOf(License::class, $license);

        return $license;
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testGetApplication(License $license)
    {
        $this->assertInstanceOf(Application::class, $license->getApplication());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testSetApplication(License $license)
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $license->setApplication($application);

        $this->assertInstanceOf(Application::class, $license->getApplication());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testGetRecipient(License $license)
    {
        $this->assertNull($license->getRecipient());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testSetRecipient(License $license)
    {
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key

        $license->setRecipient($recipient);
        $this->assertInstanceOf(Recipient::class, $license->getRecipient());

        $license->setRecipient(null);
        $this->assertNull($license->getRecipient());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testGetEmail(License $license)
    {
        $this->assertNull($license->getEmail());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testSetEmail(License $license)
    {
        $email = 'dummy@email.com';

        $license->setEmail($email);
        $this->assertEquals($email, $license->getEmail());

        $license->setEmail(null);
        $this->assertNull($license->getEmail());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testGetOs(License $license)
    {
        $this->assertNull($license->getOs());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testSetOs(License $license)
    {
        $license->setOs(License::OS_ANDROID);
        $this->assertEquals(License::OS_ANDROID, $license->getOs());

        $license->setOs(License::OS_ANY);
        $this->assertNull($license->getOs());

        $this->expectException(InvalidArgumentException::class);
        $license->setOs('Wrong_OS');
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testCanBeAssigned(License $license)
    {
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $email = 'dummy@email.com';

        $this->assertFalse($license->canBeAssigned());

        $license->setRecipient($recipient);
        $this->assertTrue($license->canBeAssigned());

        $license->setEmail($email);
        $this->assertTrue($license->canBeAssigned());

        $license->setRecipient(null);
        $this->assertTrue($license->canBeAssigned());

        $license->setEmail(null);
        $this->assertFalse($license->canBeAssigned());
    }

    /**
     * @depends testCanBeCreated
     * @param License $license
     */
    public function testGetAvailableOsTypes(License $license)
    {
        $licenseTypes = array(
            'OS_ANDROID' => "Android",
            'OS_IOS' => "iOS",
            'OS_DESKTOP' => "Desktop",
            'OS_ANY' => null,
        );

        $this->assertEquals($licenseTypes, $license->getAvailableOsTypes());
    }
}
