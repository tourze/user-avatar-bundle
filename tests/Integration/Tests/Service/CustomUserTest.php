<?php

namespace Tourze\UserAvatarBundle\Tests\Integration\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;
use Tourze\UserAvatarBundle\Tests\Service\CustomUser;

class CustomUserTest extends TestCase
{
    public function test_interfaceExists(): void
    {
        $this->assertTrue(interface_exists(CustomUser::class));
    }

    public function test_interfaceExtendsUserInterface(): void
    {
        $reflection = new \ReflectionClass(CustomUser::class);
        $this->assertTrue($reflection->isInterface());
        
        $interfaces = $reflection->getInterfaceNames();
        $this->assertContains(UserInterface::class, $interfaces);
    }

    public function test_interfaceHasGetAvatarMethod(): void
    {
        $reflection = new \ReflectionClass(CustomUser::class);
        $this->assertTrue($reflection->hasMethod('getAvatar'));
        
        $method = $reflection->getMethod('getAvatar');
        $this->assertTrue($method->isPublic());
        $this->assertCount(0, $method->getParameters());
    }

    public function test_interfaceHasGetEmailMethod(): void
    {
        $reflection = new \ReflectionClass(CustomUser::class);
        $this->assertTrue($reflection->hasMethod('getEmail'));
        
        $method = $reflection->getMethod('getEmail');
        $this->assertTrue($method->isPublic());
        $this->assertCount(0, $method->getParameters());
    }
}