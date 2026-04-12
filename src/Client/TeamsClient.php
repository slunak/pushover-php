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

namespace Serhiy\Pushover\Client;

use Serhiy\Pushover\Api\Teams\Team;
use Serhiy\Pushover\Api\Teams\User;
use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Exception\InvalidArgumentException;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class TeamsClient extends Client implements ClientInterface
{
    public const ACTION_RETRIEVE_TEAM = 'retrieve_team';
    public const ACTION_ADD_USER = 'add_user';
    public const ACTION_REMOVE_USER = 'remove_user';

    /**
     * @param self::ACTION_* $action Action that client performs
     */
    public function __construct(
        private readonly Team $team,
        private readonly string $action,
    ) {
        $this->validateAction($action);
    }

    public function buildApiUrl(): string
    {
        return match ($this->action) {
            self::ACTION_RETRIEVE_TEAM => sprintf('%s/%s/teams.json?token=%s', Curl::API_BASE_URL, Curl::API_VERSION, $this->team->getToken()),
            default => sprintf('%s/%s/teams/%s.json', Curl::API_BASE_URL, Curl::API_VERSION, $this->action),
        };
    }

    /**
     * @return array<string, string>
     */
    public function buildCurlPostFields(?User $user = null): array
    {
        $curlPostFields = [
            'token' => $this->team->getToken(),
        ];

        if (\in_array($this->action, [self::ACTION_ADD_USER, self::ACTION_REMOVE_USER], true)) {
            if (!$user instanceof User) {
                throw new \LogicException('User object must be provided for this action.');
            }

            $curlPostFields['email'] = $user->getEmail();
        }

        if (self::ACTION_ADD_USER === $this->action) {
            if (null !== $user->getName()) {
                $curlPostFields['name'] = $user->getName();
            }

            if (null !== $user->getPassword()) {
                $curlPostFields['password'] = $user->getPassword();
            }

            if ($user->isInstant()) {
                $curlPostFields['instant'] = 'true';
            }

            if ($user->isAdministrator()) {
                $curlPostFields['admin'] = 'true';
            }

            if (null !== $user->getGroup()) {
                $curlPostFields['group'] = $user->getGroup();
            }
        }

        return $curlPostFields;
    }

    /**
     * Checks if the action provided into construct is valid.
     */
    private function validateAction(string $action): void
    {
        $oClass = new \ReflectionClass(self::class);

        if (!\in_array($action, $oClass->getConstants(), true)) {
            throw new InvalidArgumentException('Action argument provided to construct method is invalid.');
        }
    }
}
