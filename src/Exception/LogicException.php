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

namespace Serhiy\Pushover\Exception;

/**
 * Base LogicException for the Pushover component.
 *
 * @author Serhiy Lunak
 */
class LogicException extends \LogicException implements ExceptionInterface
{
}
