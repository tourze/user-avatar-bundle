<?php

namespace Tourze\UserAvatarBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\UserAvatarBundle\DependencyInjection\UserAvatarExtension;
use Tourze\UserAvatarBundle\Service\DefaultAvatarService;

class UserAvatarExtensionTest extends TestCase
{
    public function test_load_registersServices(): void
    {
        $container = new ContainerBuilder();
        $extension = new UserAvatarExtension();
        
        $extension->load([], $container);
        
        // 检查是否注册了服务
        $this->assertTrue($container->has(DefaultAvatarService::class));
        
        // 检查服务是否正确配置
        $definition = $container->getDefinition(DefaultAvatarService::class);
        $this->assertTrue($definition->isAutowired());
        $this->assertTrue($definition->isAutoconfigured());
        $this->assertFalse($definition->isPublic());
    }
} 