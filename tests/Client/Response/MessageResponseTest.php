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

namespace Client\Response;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Response\MessageResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class MessageResponseTest extends TestCase
{
    public function testCanBeCrated(): void
    {
        $successfulCurlResponse = '{"receipt":"gggg7777GGGG7777hhhh8888HHHH88","status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new MessageResponse($successfulCurlResponse);

        $this->assertInstanceOf(MessageResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame('gggg7777GGGG7777hhhh8888HHHH88', $response->getReceipt());

        $unSuccessfulCurlResponse = '{"user":"invalid","errors":["user identifier is not a valid user, group, or subscribed user key"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new MessageResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(MessageResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'user identifier is not a valid user, group, or subscribed user key'], $response->getErrors());
    }

    public function testGetReceipt(): void
    {
        $successfulCurlResponse = '{"receipt":"gggg7777GGGG7777hhhh8888HHHH88","status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new MessageResponse($successfulCurlResponse);

        $this->assertSame('gggg7777GGGG7777hhhh8888HHHH88', $response->getReceipt());
    }
}
