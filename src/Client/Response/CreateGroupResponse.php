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
 * @author Serhiy Lunak
 */
class CreateGroupResponse extends Response
{
    /**
     * Obtained group key.
     */
    private string $groupKey;

    public function __construct(string $curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    /**
     * @return string Obtained group key
     */
    public function getGroupKey(): string
    {
        return $this->groupKey;
    }

    private function processCurlResponse(string $curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() === 1) {
            $this->groupKey = $decodedCurlResponse->group;
        }
    }
}
