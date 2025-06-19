<?php

namespace Tourze\UserAvatarBundle\Service;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsAlias(AvatarServiceInterface::class, public: true)]
class DefaultAvatarService implements AvatarServiceInterface
{
    public function getLink(?UserInterface $user, int $size = 128): string
    {
        $default = $_ENV['DEFAULT_USER_AVATAR_URL'];

        if ($user !== null) {
            // TODO: 需要根据实际 User 实体类型修改方法调用
            if (method_exists($user, 'getAvatar') && $user->getAvatar()) {
                return $user->getAvatar();
            }
            // 如果有邮箱，则使用Gravatar
            if (method_exists($user, 'getEmail') && $user->getEmail()) {
                return 'https://www.gravatar.com/avatar/'
                    . hash('sha256', strtolower(trim($user->getEmail())))
                    . '?d=' . urlencode($default) . '&s=' . $size;
            }
        }

        return $default;
    }

    public function syncAvatarToLocal(UserInterface $user): void
    {
        // TODO
    }
}
