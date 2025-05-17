<?php

namespace Tourze\UserAvatarBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;
use Tourze\UserAvatarBundle\Service\DefaultAvatarService;

class DefaultAvatarServiceTest extends TestCase
{
    private DefaultAvatarService $service;
    private string $defaultAvatarUrl = 'https://example.com/default-avatar.png';

    protected function setUp(): void
    {
        $this->service = new DefaultAvatarService();
        $_ENV['DEFAULT_USER_AVATAR_URL'] = $this->defaultAvatarUrl;
    }

    public function test_getLink_withNullUser_returnsDefaultUrl(): void
    {
        $result = $this->service->getLink(null);
        $this->assertEquals($this->defaultAvatarUrl, $result);
    }

    public function test_getLink_withUserHavingAvatar_returnsUserAvatar(): void
    {
        $avatarUrl = 'https://example.com/custom-avatar.png';
        
        $user = $this->createMock(CustomUser::class);
        $user->method('getAvatar')->willReturn($avatarUrl);
        
        $result = $this->service->getLink($user);
        $this->assertEquals($avatarUrl, $result);
    }

    public function test_getLink_withUserHavingEmail_returnsGravatarUrl(): void
    {
        $email = 'user@example.com';
        
        $user = $this->createMock(CustomUser::class);
        $user->method('getAvatar')->willReturn(null);
        $user->method('getEmail')->willReturn($email);
        
        $result = $this->service->getLink($user);
        
        $expectedHash = hash('sha256', strtolower(trim($email)));
        $expectedUrl = 'https://www.gravatar.com/avatar/' . $expectedHash . 
            '?d=' . urlencode($this->defaultAvatarUrl) . '&s=128';
        
        $this->assertEquals($expectedUrl, $result);
    }

    public function test_getLink_withUserHavingNoAvatarAndNoEmail_returnsDefaultUrl(): void
    {
        $user = $this->createMock(CustomUser::class);
        $user->method('getAvatar')->willReturn(null);
        $user->method('getEmail')->willReturn(null);
        
        $result = $this->service->getLink($user);
        $this->assertEquals($this->defaultAvatarUrl, $result);
    }

    public function test_getLink_withCustomSize_returnsGravatarUrlWithCorrectSize(): void
    {
        $email = 'user@example.com';
        $customSize = 256;
        
        $user = $this->createMock(CustomUser::class);
        $user->method('getAvatar')->willReturn(null);
        $user->method('getEmail')->willReturn($email);
        
        $result = $this->service->getLink($user, $customSize);
        
        $expectedHash = hash('sha256', strtolower(trim($email)));
        $expectedUrl = 'https://www.gravatar.com/avatar/' . $expectedHash . 
            '?d=' . urlencode($this->defaultAvatarUrl) . '&s=' . $customSize;
        
        $this->assertEquals($expectedUrl, $result);
    }

    public function test_syncAvatarToLocal_doesNotThrowException(): void
    {
        $user = $this->createMock(CustomUser::class);
        
        // 检查方法是否可以执行，不抛出异常
        $this->assertNull($this->service->syncAvatarToLocal($user));
    }
}

/**
 * 为测试创建的自定义用户类
 */
interface CustomUser extends UserInterface
{
    public function getAvatar(): ?string;
    public function getEmail(): ?string;
} 