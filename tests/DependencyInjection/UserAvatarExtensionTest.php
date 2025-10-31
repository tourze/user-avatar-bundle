<?php

declare(strict_types=1);

namespace Tourze\UserAvatarBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use Tourze\UserAvatarBundle\DependencyInjection\UserAvatarExtension;

/**
 * @internal
 */
#[CoversClass(UserAvatarExtension::class)]
final class UserAvatarExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
}
