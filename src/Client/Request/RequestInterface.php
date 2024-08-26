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

namespace Serhiy\Pushover\Client\Request;

/**
 * @author Serhiy Lunak
 */
interface RequestInterface
{
    public function getMethod(): string;

    public function getApiUrl(): string;

    /**
     * @return null|array[]
     */
    public function getCurlPostFields(): ?array;
}
