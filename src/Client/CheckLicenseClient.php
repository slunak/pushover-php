<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Api\Licensing\License;
use Serhiy\Pushover\Client\Curl\Curl;

/**
 * @author Serhiy Lunak
 */
class CheckLicenseClient extends Client implements ClientInterface
{
    public const API_PATH = "licenses.json";

    /**
     * @var License
     */
    private $license;

    public function __construct(License $license)
    {
        $this->license = $license;
    }

    public function buildApiUrl()
    {
        return Curl::API_BASE_URL."/".Curl::API_VERSION."/".self::API_PATH."?token=".$this->license->getApplication()->getToken();
    }
}
