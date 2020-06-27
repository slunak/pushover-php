<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient;

use Serhiy\Pushover\ApiClient\Message\MessageResponse;

/**
 * Client Interface.
 *
 * @author Serhiy Lunak
 */
interface ClientInterface
{
    /**
     * @return string
     */
    public function buildApiUrl();

    /**
     * @param Request $request
     * @return MessageResponse
     */
    public function send(Request $request);
}
