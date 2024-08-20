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

use Serhiy\Pushover\Api\Glances\GlanceDataFields;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak
 */
class GlanceDataFieldsTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertInstanceOf(GlanceDataFields::class, $glanceDataFields);
    }

    public function testSetTitle(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $glanceDataFields->setTitle('This is test title');
        $this->assertEquals('This is test title', $glanceDataFields->getTitle());

        $glanceDataFields->setTitle(null);
        $this->assertNull($glanceDataFields->getTitle());

        $glanceDataFields->setTitle('');
        $this->assertEquals('', $glanceDataFields->getTitle());

        $this->expectException(InvalidArgumentException::class);
        $glanceDataFields->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    }

    public function testSetText(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $glanceDataFields->setText('This is test text');
        $this->assertEquals('This is test text', $glanceDataFields->getText());

        $glanceDataFields->setText(null);
        $this->assertNull($glanceDataFields->getText());

        $glanceDataFields->setText('');
        $this->assertEquals('', $glanceDataFields->getText());

        $this->expectException(InvalidArgumentException::class);
        $glanceDataFields->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    }

    public function testSetSubtext(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $glanceDataFields->setSubtext('This is test subtext');
        $this->assertEquals('This is test subtext', $glanceDataFields->getSubtext());

        $glanceDataFields->setSubtext(null);
        $this->assertNull($glanceDataFields->getSubtext());

        $glanceDataFields->setSubtext('');
        $this->assertEquals('', $glanceDataFields->getSubtext());

        $this->expectException(InvalidArgumentException::class);
        $glanceDataFields->setSubtext('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    }

    public function testSetCount(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $glanceDataFields->setCount(0);
        $this->assertEquals(0, $glanceDataFields->getCount());

        $glanceDataFields->setCount(-1000);
        $this->assertEquals(-1000, $glanceDataFields->getCount());

        $glanceDataFields->setCount(1000);
        $this->assertEquals(1000, $glanceDataFields->getCount());
    }

    public function testSetPercent(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $glanceDataFields->setPercent(0);
        $this->assertEquals(0, $glanceDataFields->getPercent());

        $glanceDataFields->setPercent(100);
        $this->assertEquals(100, $glanceDataFields->getPercent());

        $this->expectException(InvalidArgumentException::class);
        $glanceDataFields->setPercent(101);
    }

    public function testGetTitle(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getTitle());
    }

    public function testGetText(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getText());
    }

    public function testGetSubtext(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getSubtext());
    }

    public function testGetCount(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getCount());
    }

    public function testGetPercent(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getPercent());
    }
}
