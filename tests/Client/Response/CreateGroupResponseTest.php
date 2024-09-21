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
use Serhiy\Pushover\Client\Response\CreateGroupResponse;

final class CreateGroupResponseTest extends TestCase
{
    public function testSuccessfulResponse(): CreateGroupResponse
    {
        $response = new CreateGroupResponse('{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc","group":"go4abk17j3itsva6thz99mdudgq2gm"}');

        $this->assertInstanceOf(CreateGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    public function testUnsuccessfulResponse(): void
    {
        $response = new CreateGroupResponse('{"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc","errors":[ "application token is invalid" ]}');

        $this->assertInstanceOf(CreateGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'application token is invalid'], $response->getErrors());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetGroup(CreateGroupResponse $response): void
    {
        $group = $response->getGroupKey();
        $this->assertSame($group, 'go4abk17j3itsva6thz99mdudgq2gm');
    }
}
