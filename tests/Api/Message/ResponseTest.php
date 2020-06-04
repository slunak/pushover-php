<?php

/*
 * This file is part of the Pushover package.
 *
 *  (c) Serhiy Lunak <https://github.com/slunak>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Response;

/**
 * @author Serhiy Lunak
 */
class ResponseTest extends TestCase
{
    public function testCanBeCrated()
    {
        $response = new Response(1, '11111111-aaaa-2222-bbbb-333333cccccc');

        $this->assertInstanceOf(Response::class, $response);
    }
}
