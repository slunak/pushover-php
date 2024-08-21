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

namespace Api\Receipts;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Receipts\Receipt;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\CancelRetryResponse;
use Serhiy\Pushover\Client\Response\ReceiptResponse;

/**
 * @author Serhiy Lunak
 */
class ReceiptTest extends TestCase
{
    public function testCanBeCreated()
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token

        $receipt = new Receipt($application);

        $this->assertInstanceOf(Receipt::class, $receipt);

        return $receipt;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetApplication(Receipt $receipt): void
    {
        $application = $receipt->getApplication();

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals('cccc3333CCCC3333dddd4444DDDD44', $application->getToken());
    }

    /**
     * @group Integration
     */
    public function testQuery(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $receipt = new Receipt($application);

        $response = $receipt->query('gggg7777GGGG7777hhhh8888HHHH88'); // using dummy receipt

        $this->assertInstanceOf(ReceiptResponse::class, $response);
    }

    /**
     * @group Integration
     */
    public function testCancelRetry(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $receipt = new Receipt($application);

        $response = $receipt->cancelRetry('gggg7777GGGG7777hhhh8888HHHH88'); // using dummy receipt

        $this->assertInstanceOf(CancelRetryResponse::class, $response);
    }
}
