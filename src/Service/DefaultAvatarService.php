<?php

namespace Tourze\UserAvatarBundle\Service;

use AppBundle\Entity\BizUser;
use AppBundle\Service\AvatarService;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(AvatarService::class, public: true)]
class DefaultAvatarService implements AvatarService
{
    public function getLink(?BizUser $user, int $size = 128): string
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

    public function syncAvatarToLocal(BizUser $user): void
    {
        // TODO
    }
}
