<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Glances;

use Serhiy\Pushover\Api\Glances\Glance;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Glances\GlanceDataFields;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class GlanceTest extends TestCase
{
    /**
     * @return Glance
     */
    public function testCanBeCreated(): Glance
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $glanceDataFields = new GlanceDataFields();

        $glance = new Glance($application, $glanceDataFields);
        $glance->setRecipient($recipient);

        $this->assertInstanceOf(Glance::class, $glance);

        return $glance;
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testGetGlanceDataFields(Glance $glance)
    {
        $this->assertInstanceOf(GlanceDataFields::class, $glance->getGlanceDataFields());
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testGetApplication(Glance $glance)
    {
        $this->assertInstanceOf(Application::class, $glance->getApplication());
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testGetRecipient(Glance $glance)
    {
        $this->assertInstanceOf(Recipient::class, $glance->getRecipient());
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testSetApplication(Glance $glance)
    {
        $application = new Application("zaGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $glance->setApplication($application);

        $this->assertInstanceOf(Application::class, $glance->getApplication());
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testSetGlanceDataFields(Glance $glance)
    {
        $glanceDataFields = new GlanceDataFields();
        $glance->setGlanceDataFields($glanceDataFields);

        $this->assertInstanceOf(GlanceDataFields::class, $glance->getGlanceDataFields());
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testSetRecipient(Glance $glance)
    {
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $glance->setRecipient($recipient);

        $this->assertInstanceOf(Recipient::class, $recipient);
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testHasAtLeastOneField(Glance $glance)
    {
        $this->assertFalse($glance->hasAtLeastOneField());

        $glance->getGlanceDataFields()->setTitle("This is test title");

        $this->assertTrue($glance->hasAtLeastOneField());
    }

    /**
     * @depends testCanBeCreated
     * @param Glance $glance
     */
    public function testHasRecipient(Glance $glance)
    {
        $this->assertTrue($glance->hasRecipient());
    }
}
