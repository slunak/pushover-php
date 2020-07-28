<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Response;

use Serhiy\Pushover\Client\Response\EnableUserInGroupResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Serhiy Lunak
 */
class EnableUserInGroupResponseTest extends TestCase
{
    public function testCenBeCreated()
    {
        $curlResponse = '{"status":1,"request":"6g890a90-7943-4at2-b739-4aubi545b508"}';
        $response = new EnableUserInGroupResponse($curlResponse);

        $this->assertInstanceOf(EnableUserInGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
    }
}
