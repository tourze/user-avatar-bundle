<?php

namespace Tourze\UserAvatarBundle\Service;

use Symfony\Component\Security\Core\User\UserInterface;

interface AvatarServiceInterface
{
    /**
     * 获取指定用户的头像地址
     */
    public function getLink(?UserInterface $user, int $size = 128): string;

    /**
     * 同步用户头像到本地
     */
    public function syncAvatarToLocal(UserInterface $user): void;
}
