<?php

declare(strict_types=1);

namespace Tourze\UserAvatarBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use Tourze\UserAvatarBundle\UserAvatarBundle;

/**
 * @internal
 */
#[CoversClass(UserAvatarBundle::class)]
#[RunTestsInSeparateProcesses]
final class UserAvatarBundleTest extends AbstractBundleTestCase
{
}
