<?php

declare(strict_types=1);

namespace Tourze\UserAvatarBundle\Tests\Service;

use Symfony\Component\Security\Core\User\UserInterface;

interface TestUserInterface extends UserInterface
{
    public function getAvatar(): ?string;

    public function getEmail(): ?string;
}
