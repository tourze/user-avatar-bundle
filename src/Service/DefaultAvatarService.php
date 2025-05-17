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

        if ($user) {
            if ($user?->getAvatar()) {
                return $user->getAvatar();
            }
            // 如果有邮箱，则使用Gravatar
            if ($user->getEmail()) {
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
