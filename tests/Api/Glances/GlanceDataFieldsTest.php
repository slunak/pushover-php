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

namespace Api\Glances;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Glances\GlanceDataFields;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class GlanceDataFieldsTest extends TestCase
{
    public function testCanBeConstructed(): void
    {
        $this->assertInstanceOf(GlanceDataFields::class, new GlanceDataFields());
    }

    #[DataProvider('setTitleProvider')]
    public function testSetTitle(?string $expected, ?string $value): void
    {
        $glanceDataFields = (new GlanceDataFields())
            ->setTitle($value);

        $this->assertSame($expected, $glanceDataFields->getTitle());
    }

    /**
     * @return iterable<array{?string, ?string}>
     */
    public static function setTitleProvider(): iterable
    {
        yield [null, null];
        yield ['This is test title', 'This is test title'];
        yield ['', ''];
    }

    public function testSetTitleThrowsInvalidArgumentExceptionIfValueIsAbove100(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new GlanceDataFields())->setTitle(str_repeat('a', 101));
    }

    #[DataProvider('setTextProvider')]
    public function testSetText(?string $expected, ?string $value): void
    {
        $glanceDataFields = (new GlanceDataFields())
            ->setText($value);

        $this->assertSame($expected, $glanceDataFields->getText());
    }
    /**
     * @return iterable<array{?string, ?string}>
     */
    public static function setTextProvider(): iterable
    {
        yield [null, null];
        yield ['This is test text', 'This is test text'];
        yield ['', ''];
    }

    public function testSetTextThrowsInvalidArgumentExceptionIfValueIsAbove100(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new GlanceDataFields())->setText(str_repeat('a', 101));
    }

    #[DataProvider('setSubtextProvider')]
    public function testSetSubtext(?string $expected, ?string $value): void
    {
        $glanceDataFields = (new GlanceDataFields())
            ->setSubtext($value);

        $this->assertSame($expected, $glanceDataFields->getSubtext());
    }

    /**
     * @return iterable<array{?string, ?string}>
     */
    public static function setSubtextProvider(): iterable
    {
        yield [null, null];
        yield ['This is test subtext', 'This is test subtext'];
        yield ['', ''];
    }

    public function testSetSubtextThrowsInvalidArgumentExceptionIfValueIsAbove100(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new GlanceDataFields())->setSubtext(str_repeat('a', 101));
    }

    #[DataProvider('setCountProvider')]
    public function testSetCount(int $value): void
    {
        $glanceDataFields = (new GlanceDataFields())
            ->setCount($value);

        $this->assertSame($value, $glanceDataFields->getCount());
    }

    /**
     * @return iterable<int[]>
     */
    public static function setCountProvider(): iterable
    {
        yield [0];
        yield [-1000];
        yield [1000];
    }

    public function testSetPercentThrowsInvalidArgumentExceptionIfValueIsAbove100(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new GlanceDataFields())->setPercent(101);
    }

    public function testSetPercentThrowsInvalidArgumentExceptionIfValueIsBelowMinus1(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new GlanceDataFields())->setPercent(-1);
    }

    #[DataProvider('setPercentProvider')]
    public function testSetPercent(int $value): void
    {
        $glanceDataFields = (new GlanceDataFields())
            ->setPercent($value);

        $this->assertSame($value, $glanceDataFields->getPercent());
    }

    /**
     * @return iterable<int[]>
     */
    public static function setPercentProvider(): iterable
    {
        yield [0];
        yield [100];
        yield [50];
    }

    public function testGetTitleReturnsNullPerDefault(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getTitle());
    }

    public function testGetTextReturnsNullPerDefault(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getText());
    }

    public function testGetSubtextReturnsNullPerDefault(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getSubtext());
    }

    public function testGetCountReturnsNullPerDefault(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getCount());
    }

    public function testGetPercentReturnsNullPerDefault(): void
    {
        $glanceDataFields = new GlanceDataFields();

        $this->assertNull($glanceDataFields->getPercent());
    }
}
