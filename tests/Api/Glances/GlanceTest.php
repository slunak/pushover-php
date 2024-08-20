<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Glances;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Glances\Glance;
use Serhiy\Pushover\Api\Glances\GlanceDataFields;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\GlancesResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class GlanceTest extends TestCase
{
    public function testCanBeCreated(): Glance
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $glanceDataFields = new GlanceDataFields();

        $glance = new Glance($application, $glanceDataFields);
        $glance->setRecipient($recipient);

        $this->assertInstanceOf(Glance::class, $glance);

        return $glance;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetGlanceDataFields(Glance $glance): void
    {
        $this->assertInstanceOf(GlanceDataFields::class, $glance->getGlanceDataFields());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetApplication(Glance $glance): void
    {
        $this->assertInstanceOf(Application::class, $glance->getApplication());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetRecipient(Glance $glance): void
    {
        $this->assertInstanceOf(Recipient::class, $glance->getRecipient());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetApplication(Glance $glance): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $glance->setApplication($application);

        $this->assertInstanceOf(Application::class, $glance->getApplication());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetGlanceDataFields(Glance $glance): void
    {
        $glanceDataFields = new GlanceDataFields();
        $glance->setGlanceDataFields($glanceDataFields);

        $this->assertInstanceOf(GlanceDataFields::class, $glance->getGlanceDataFields());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetRecipient(Glance $glance): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $glance->setRecipient($recipient);

        $this->assertInstanceOf(Recipient::class, $recipient);
    }

    /**
     * @depends testCanBeCreated
     */
    public function testHasAtLeastOneField(Glance $glance): void
    {
        $this->assertFalse($glance->hasAtLeastOneField());

        $glance->getGlanceDataFields()->setTitle('This is test title');

        $this->assertTrue($glance->hasAtLeastOneField());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testHasRecipient(Glance $glance): void
    {
        $this->assertTrue($glance->hasRecipient());
    }

    /**
     * @group Integration
     */
    public function testPush(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        $glanceDataFields = new GlanceDataFields();
        $glanceDataFields
            ->setTitle('Title')
            ->setText('Text Test')
            ->setSubtext('Subtext Test')
            ->setCount(199)
            ->setPercent(99);

        $glance = new Glance($application, $glanceDataFields);
        $glance->setRecipient($recipient);
        $response = $glance->push();

        $this->assertInstanceOf(GlancesResponse::class, $response);
    }
}
