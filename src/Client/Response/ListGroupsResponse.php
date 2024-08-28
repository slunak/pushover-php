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
 * @author Vítězslav Dvořák
 */
final class ListGroupsResponse extends Response
{
    /** @var array<string, string> */
    public array $groups = [];

    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    /**
     * List of groups.
     *
     * @return array<string, string> group names with keys eg. ['name' => 'key', ...]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if (property_exists($decodedCurlResponse, 'groups')) {
            foreach ($decodedCurlResponse->groups as $grp) {
                $this->groups[$grp->name] = $grp->group;
            }
        }
    }
}
