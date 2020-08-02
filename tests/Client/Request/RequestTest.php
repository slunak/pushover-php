<?php

/*
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
        $request = new Request("https://test.com/api", Request::POST, array());

        $this->assertInstanceOf(Request::class, $request);

        return $request;
    }

    /**
     * @depends testCanBeCrated
     * @param Request $request
     */
    public function testGetMethod(Request $request)
    {
        $this->assertEquals(Request::POST, $request->getMethod());
    }

    /**
     * @depends testCanBeCrated
     * @param Request $request
     */
    public function testGetApiUrl(Request $request)
    {
        $this->assertEquals("https://test.com/api", $request->getApiUrl());
    }

    /**
     * @depends testCanBeCrated
     * @param Request $request
     */
    public function testGetCurlPostFields(Request $request)
    {
        $this->assertIsArray($request->getCurlPostFields());
    }
}
