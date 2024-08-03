<?php

/*
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
     * @var string Obtained Group Key
     */
    private $groupKey;

    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    /**
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);
        $this->groupKey = property_exists($decodedCurlResponse,'group') ? $decodedCurlResponse->group : null;
    }
    
    /**
     * @return string Group key obtained
     */
    public function getGroupKey() {
        return $this->groupKey;
    }
}