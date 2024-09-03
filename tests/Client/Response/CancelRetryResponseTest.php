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
use Serhiy\Pushover\Client\Response\CancelRetryResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class CancelRetryResponseTest extends TestCase
{
    public function testCanBeCreatedWithSuccessfulCurlResponse(): void
    {
        $response = new CancelRetryResponse('{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(CancelRetryResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
    }

    public function testCanBeCreatedWithUnsuccessfulCurlResponse(): void
    {
        $response = new CancelRetryResponse('{"receipt":"not found","errors":["receipt not found; may be invalid or expired"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(CancelRetryResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'receipt not found; may be invalid or expired'], $response->getErrors());
    }
}
