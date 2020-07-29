<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Glances;

use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * Glance Data Fields.
 * Currently the following fields are available for updating. Each field is shown differently on different screens,
 * so you may need to experiment with them to find out which field works for you given your screen and type of data.
 * For example, each watch face on the Apple Watch uses a different sized complication,
 * with different size specifications and types of data. Some are text strings, some are just numbers.
 *
 * @author Serhiy Lunak
 */
class GlanceDataFields
{
    /**
     * @var string|null (100 characters) - a description of the data being shown, such as "Widgets Sold".
     */
    private $title;

    /**
     * @var string|null (100 characters) - the main line of data, used on most screens.
     */
    private $text;

    /**
     * @var string|null (100 characters) - a second line of data.
     */
    private $subtext;

    /**
     * @var int|null (integer, may be negative) - shown on smaller screens; useful for simple counts.
     */
    private $count;

    /**
     * @var int|null (integer 0 through 100, inclusive) - shown on some screens as a progress bar/circle.
     */
    private $percent;

    public function __construct()
    {
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return GlanceDataFields
     */
    public function setTitle(?string $title): GlanceDataFields
    {
        if (strlen($title) > 100) {
            throw new InvalidArgumentException(sprintf("Title can be no more than 100 characters long. %s characters long title provided.", strlen($title)));
        }

        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return GlanceDataFields
     */
    public function setText(?string $text): GlanceDataFields
    {
        if (strlen($text) > 100) {
            throw new InvalidArgumentException(sprintf("Text can be no more than 100 characters long. %s characters long text provided.", strlen($text)));
        }

        $this->text = $text;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubtext(): ?string
    {
        return $this->subtext;
    }

    /**
     * @param string|null $subtext
     * @return GlanceDataFields
     */
    public function setSubtext(?string $subtext): GlanceDataFields
    {
        if (strlen($subtext) > 100) {
            throw new InvalidArgumentException(sprintf("Subtext can be no more than 100 characters long. %s characters long subtext provided.", strlen($subtext)));
        }

        $this->subtext = $subtext;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int|null $count
     * @return GlanceDataFields
     */
    public function setCount(?int $count): GlanceDataFields
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPercent(): ?int
    {
        return $this->percent;
    }

    /**
     * @param int|null $percent
     * @return GlanceDataFields
     */
    public function setPercent(?int $percent): GlanceDataFields
    {
        if (! ($percent >= 0 && $percent <= 100)) {
            throw new InvalidArgumentException(sprintf("Percent should be an integer 0 through 100, inclusive. %s provided.", $percent));
        }

        $this->percent = $percent;

        return $this;
    }
}
