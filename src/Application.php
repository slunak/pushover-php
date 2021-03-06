<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover;

use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * Pushover Application.
 * To get started pushing notifications from your application, plugin, web service, server, or anything else,
 * you'll first need to register it to get an API token.
 * See {@link https://pushover.net/api#registration} for more information.
 *
 * @author Serhiy Lunak
 */
class Application
{
    /**
     * API Token.
     * (required) - your application's API token
     *
     * @var string
     */
    private $token;

    public function __construct(string $token)
    {
        if (1 != preg_match("/^[a-zA-Z0-9]{30}$/", $token)) {
            throw new InvalidArgumentException(sprintf('Application tokens are case-sensitive, 30 characters long, and may contain the character set [A-Za-z0-9]. "%s" given with "%s" characters."', $token, strlen($token)));
        }

        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
