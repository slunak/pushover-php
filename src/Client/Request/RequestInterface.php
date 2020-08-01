<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client\Request;

/**
 * Request Interface.
 *
 * @author Serhiy Lunak
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getApiUrl(): string;

    /**
     * @return array[]|null
     */
    public function getCurlPostFields(): ?array;
}
