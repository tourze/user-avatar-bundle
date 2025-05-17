<?php

namespace Tourze\UserAvatarBundle\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\UserAvatarBundle\UserAvatarBundle;

class UserAvatarBundleTest extends TestCase
{
    public function test_bundle_instantiation(): void
    {
        $bundle = new UserAvatarBundle();
        $this->assertInstanceOf(UserAvatarBundle::class, $bundle);
    }
} 