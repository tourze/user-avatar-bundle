<?php

declare(strict_types=1);

namespace Tourze\UserAvatarBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use Tourze\UserAvatarBundle\Service\DefaultAvatarService;

/**
 * @internal
 */
#[CoversClass(DefaultAvatarService::class)]
#[RunTestsInSeparateProcesses]
final class DefaultAvatarServiceTest extends AbstractIntegrationTestCase
{
    private DefaultAvatarService $service;

    private string $defaultAvatarUrl = 'https://example.com/default-avatar.png';

    protected function onSetUp(): void
    {
        $this->service = self::getService(DefaultAvatarService::class);
        $_ENV['DEFAULT_USER_AVATAR_URL'] = $this->defaultAvatarUrl;
    }

    private function createUserWithAvatar(string $avatar): TestUserInterface
    {
        $user = $this->createMock(TestUserInterface::class);
        $user->method('getUserIdentifier')->willReturn('test-user');
        $user->method('getRoles')->willReturn(['ROLE_USER']);
        $user->method('getAvatar')->willReturn($avatar);
        $user->method('getEmail')->willReturn(null);

        return $user;
    }

    private function createUserWithEmail(string $email): TestUserInterface
    {
        $user = $this->createMock(TestUserInterface::class);
        $user->method('getUserIdentifier')->willReturn($email);
        $user->method('getRoles')->willReturn(['ROLE_USER']);
        $user->method('getAvatar')->willReturn(null);
        $user->method('getEmail')->willReturn($email);

        return $user;
    }

    private function createUserWithoutAvatarAndEmail(): TestUserInterface
    {
        $user = $this->createMock(TestUserInterface::class);
        $user->method('getUserIdentifier')->willReturn('test-user');
        $user->method('getRoles')->willReturn(['ROLE_USER']);
        $user->method('getAvatar')->willReturn(null);
        $user->method('getEmail')->willReturn(null);

        return $user;
    }

    public function testGetLinkWithNullUserReturnsDefaultUrl(): void
    {
        $result = $this->service->getLink(null);
        $this->assertEquals($this->defaultAvatarUrl, $result);
    }

    public function testGetLinkWithUserHavingAvatarReturnsUserAvatar(): void
    {
        $avatarUrl = 'https://example.com/custom-avatar.png';

        $user = $this->createUserWithAvatar($avatarUrl);

        $result = $this->service->getLink($user);
        $this->assertEquals($avatarUrl, $result);
    }

    public function testGetLinkWithUserHavingEmailReturnsGravatarUrl(): void
    {
        $email = 'user@example.com';

        $user = $this->createUserWithEmail($email);

        $result = $this->service->getLink($user);

        $expectedHash = hash('sha256', strtolower(trim($email)));
        $expectedUrl = 'https://www.gravatar.com/avatar/' . $expectedHash .
            '?d=' . urlencode($this->defaultAvatarUrl) . '&s=128';

        $this->assertEquals($expectedUrl, $result);
    }

    public function testGetLinkWithUserHavingNoAvatarAndNoEmailReturnsDefaultUrl(): void
    {
        $user = $this->createUserWithoutAvatarAndEmail();

        $result = $this->service->getLink($user);
        $this->assertEquals($this->defaultAvatarUrl, $result);
    }

    public function testGetLinkWithCustomSizeReturnsGravatarUrlWithCorrectSize(): void
    {
        $email = 'user@example.com';
        $customSize = 256;

        $user = $this->createUserWithEmail($email);

        $result = $this->service->getLink($user, $customSize);

        $expectedHash = hash('sha256', strtolower(trim($email)));
        $expectedUrl = 'https://www.gravatar.com/avatar/' . $expectedHash .
            '?d=' . urlencode($this->defaultAvatarUrl) . '&s=' . $customSize;

        $this->assertEquals($expectedUrl, $result);
    }

    public function testSyncAvatarToLocalDoesNotThrowException(): void
    {
        $this->expectNotToPerformAssertions();

        $user = $this->createNormalUser('test-user');

        // 检查方法是否可以执行，不抛出异常（方法返回void）
        $this->service->syncAvatarToLocal($user);
    }
}
