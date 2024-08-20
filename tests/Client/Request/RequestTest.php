<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Request;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Request\Request;

/**
 * @author Serhiy Lunak
 */
class RequestTest extends TestCase
{
    /**
     * @return Request
     */
    public function testCanBeCrated()
    {
        $request = new Request('https://test.com/api', Request::POST, []);

        $this->assertInstanceOf(Request::class, $request);

        return $request;
    }

    /**
     * @depends testCanBeCrated
     */
    public function testGetMethod(Request $request): void
    {
        $this->assertEquals(Request::POST, $request->getMethod());
    }

    /**
     * @depends testCanBeCrated
     */
    public function testGetApiUrl(Request $request): void
    {
        $this->assertEquals('https://test.com/api', $request->getApiUrl());
    }

    /**
     * @depends testCanBeCrated
     */
    public function testGetCurlPostFields(Request $request): void
    {
        $this->assertIsArray($request->getCurlPostFields());
    }
}
