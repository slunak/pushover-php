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

namespace Serhiy\Pushover\Api\Glances;

use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * Currently the following fields are available for updating. Each field is shown differently on different screens,
 * so you may need to experiment with them to find out which field works for you given your screen and type of data.
 * For example, each watch face on the Apple Watch uses a different sized complication,
 * with different size specifications and types of data. Some are text strings, some are just numbers.
 *
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class GlanceDataFields
{
    /**
     * (100 characters) - a description of the data being shown, such as "Widgets Sold".
     */
    private ?string $title;

    /**
     *  (100 characters) - the main line of data, used on most screens.
     */
    private ?string $text;

    /**
     *  (100 characters) - a second line of data.
     */
    private ?string $subtext;

    /**
     *  (integer, may be negative) - shown on smaller screens; useful for simple counts.
     */
    private ?int $count;

    /**
     *  (integer 0 through 100, inclusive) - shown on some screens as a progress bar/circle.
     */
    private ?int $percent;

    public function __construct()
    {
        $this->title = null;
        $this->text = null;
        $this->subtext = null;
        $this->count = null;
        $this->percent = null;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        if ($title !== null && \strlen($title) > 100) {
            throw new InvalidArgumentException(sprintf('Title can be no more than 100 characters long. %s characters long title provided.', \strlen($title)));
        }

        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        if ($text !== null && \strlen($text) > 100) {
            throw new InvalidArgumentException(sprintf('Text can be no more than 100 characters long. %s characters long text provided.', \strlen($text)));
        }

        $this->text = $text;

        return $this;
    }

    public function getSubtext(): ?string
    {
        return $this->subtext;
    }

    public function setSubtext(?string $subtext): self
    {
        if ($subtext !== null && \strlen($subtext) > 100) {
            throw new InvalidArgumentException(sprintf('Subtext can be no more than 100 characters long. %s characters long subtext provided.', \strlen($subtext)));
        }

        $this->subtext = $subtext;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getPercent(): ?int
    {
        return $this->percent;
    }

    public function setPercent(?int $percent): self
    {
        if (!($percent >= 0 && $percent <= 100)) {
            throw new InvalidArgumentException(sprintf('Percent should be an integer 0 through 100, inclusive. %s provided.', $percent));
        }

        $this->percent = $percent;

        return $this;
    }
}
