<?php

declare(strict_types=1);

namespace Tourze\UserAvatarBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\UserAvatarBundle\Service\AvatarServiceInterface;

/**
 * @internal
 */
#[CoversClass(AvatarServiceInterface::class)]
final class AvatarServiceInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(AvatarServiceInterface::class));
    }

    public function testInterfaceHasGetLinkMethod(): void
    {
        $reflection = new \ReflectionClass(AvatarServiceInterface::class);
        $this->assertTrue($reflection->hasMethod('getLink'));

        $method = $reflection->getMethod('getLink');
        $this->assertTrue($method->isPublic());
        $this->assertCount(2, $method->getParameters());

        $parameters = $method->getParameters();
        $this->assertEquals('user', $parameters[0]->getName());
        $this->assertEquals('size', $parameters[1]->getName());
        $this->assertTrue($parameters[1]->isDefaultValueAvailable());
        $this->assertEquals(128, $parameters[1]->getDefaultValue());
    }

    public function testInterfaceHasSyncAvatarToLocalMethod(): void
    {
        $reflection = new \ReflectionClass(AvatarServiceInterface::class);
        $this->assertTrue($reflection->hasMethod('syncAvatarToLocal'));

        $method = $reflection->getMethod('syncAvatarToLocal');
        $this->assertTrue($method->isPublic());
        $this->assertCount(1, $method->getParameters());

        $parameters = $method->getParameters();
        $this->assertEquals('user', $parameters[0]->getName());
    }
}
