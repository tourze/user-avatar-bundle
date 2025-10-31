<?php

declare(strict_types=1);

namespace Tourze\UserAvatarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserAvatarBundle extends Bundle
{
    /**
     * @return array<string, bool>
     */
    public static function getBundleDependencies(): array
    {
        return ['all' => true];
    }
}
