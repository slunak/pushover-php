<?php

/*
 * This file is part of the PushoverBundle package.
 *
 *  (c) Serhiy Lunak <https://github.com/slunak>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api;

/**
 * Base class for Pushover HTTP Client.
 *
 * @author Serhiy Lunak
 */
class ApiClient
{
    /**
     * API base URL.
     */
    const API_BASE_URL = 'https://api.pushover.net';

    /**
     * API version.
     */
    const API_VERSION = '1';
}
