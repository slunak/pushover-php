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

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Response\ReceiptResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
class ReceiptResponseTest extends TestCase
{
    public function testCanBeConstructed(): ReceiptResponse
    {
        $unSuccessfulCurlResponse = '{"receipt":"not found","errors":["receipt not found; may be invalid or expired"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new ReceiptResponse($unSuccessfulCurlResponse);

        $this->assertInstanceOf(ReceiptResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertEquals([0 => 'receipt not found; may be invalid or expired'], $response->getErrors());

        $successfulCurlResponse = '{"status":1,"acknowledged":1,"acknowledged_at":1593975206,"acknowledged_by":"aaaa1111AAAA1111bbbb2222BBBB22","acknowledged_by_device":"test-device-1","last_delivered_at":1593975186,"expired":1,"expires_at":1593975485,"called_back":1,"called_back_at":1593975206,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}';
        $response = new ReceiptResponse($successfulCurlResponse);

        $this->assertInstanceOf(ReceiptResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    #[Depends('testCanBeConstructed')]
    public function testGetAcknowledgedBy(ReceiptResponse $response): void
    {
        $this->assertInstanceOf(Recipient::class, $response->getAcknowledgedBy());
        $this->assertEquals('aaaa1111AAAA1111bbbb2222BBBB22', $response->getAcknowledgedBy()->getUserKey());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetAcknowledgedByDevice(ReceiptResponse $response): void
    {
        $this->assertEquals('test-device-1', $response->getAcknowledgedByDevice());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetExpiresAt(ReceiptResponse $response): void
    {
        $this->assertInstanceOf(\DateTime::class, $response->getExpiresAt());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetLastDeliveredAt(ReceiptResponse $response): void
    {
        $this->assertInstanceOf(\DateTime::class, $response->getLastDeliveredAt());
    }

    #[Depends('testCanBeConstructed')]
    public function testIsAcknowledged(ReceiptResponse $response): void
    {
        $this->assertTrue($response->isAcknowledged());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetCalledBackAt(ReceiptResponse $response): void
    {
        $this->assertInstanceOf(\DateTime::class, $response->getCalledBackAt());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetAcknowledgedAt(ReceiptResponse $response): void
    {
        $this->assertInstanceOf(\DateTime::class, $response->getAcknowledgedAt());
    }

    #[Depends('testCanBeConstructed')]
    public function testHasCalledBack(ReceiptResponse $response): void
    {
        $this->assertTrue($response->hasCalledBack());
    }

    #[Depends('testCanBeConstructed')]
    public function testIsExpired(ReceiptResponse $response): void
    {
        $this->assertTrue($response->isExpired());
    }
}
