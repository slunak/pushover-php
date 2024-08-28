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

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class RenameGroupResponse extends Response
{
    public function __construct(string $curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    /**
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $this->processInitialCurlResponse($curlResponse);
    }
}
