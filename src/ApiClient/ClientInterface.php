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
use Serhiy\Pushover\ApiClient\UserGroupValidation\UserGroupValidationResponse;

/**
 * Client Interface.
 *
 * @author Serhiy Lunak
 */
interface ClientInterface
{
    /**
     * Builds and returns full API URL
     *
     * @return string
     */
    public function buildApiUrl();

    /**
     * Send request and returns response object.
     *
     * @param Request $request
     * @return MessageResponse|UserGroupValidationResponse
     */
    public function send(Request $request);
}
