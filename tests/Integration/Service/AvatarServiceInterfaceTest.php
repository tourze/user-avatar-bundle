<?php

namespace Tourze\UserAvatarBundle\Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;
use Tourze\UserAvatarBundle\Service\AvatarServiceInterface;

class AvatarServiceInterfaceTest extends TestCase
{
    public function test_interfaceExists(): void
    {
        $this->assertTrue(interface_exists(AvatarServiceInterface::class));
    }

    public function test_interfaceHasGetLinkMethod(): void
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

    public function test_interfaceHasSyncAvatarToLocalMethod(): void
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