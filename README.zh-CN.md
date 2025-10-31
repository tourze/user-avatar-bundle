# 用户头像服务包

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/user-avatar-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/user-avatar-bundle?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)
[![License](https://img.shields.io/packagist/l/tourze/user-avatar-bundle?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/user-avatar-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)

一个 Symfony 包，提供用户头像服务，支持自定义头像、Gravatar 集成和默认头像回退。

## 功能特性

- **自定义头像支持**: 当用户有自定义头像时优先显示
- **Gravatar 集成**: 基于用户邮箱自动生成 Gravatar URL
- **默认头像回退**: 当用户没有自定义头像或邮箱时显示默认头像
- **可配置尺寸**: 支持不同的头像尺寸（默认 128px）
- **可扩展接口**: 易于扩展自定义头像实现

## 安装

```bash
composer require tourze/user-avatar-bundle
```

## 快速开始

1. 在 `config/bundles.php` 中添加包：

```php
<?php

return [
    // ... 其他包
    Tourze\UserAvatarBundle\UserAvatarBundle::class => ['all' => true],
];
```

2. 在环境配置中设置默认头像 URL：

```bash
# .env
DEFAULT_USER_AVATAR_URL=https://example.com/default-avatar.png
```

3. 在应用程序中使用头像服务：

```php
<?php

use Tourze\UserAvatarBundle\Service\AvatarServiceInterface;

class UserController
{
    public function __construct(
        private AvatarServiceInterface $avatarService
    ) {}

    public function show(UserInterface $user): Response
    {
        // 获取用户头像 URL（默认尺寸 128px）
        $avatarUrl = $this->avatarService->getLink($user);
        
        // 获取用户头像 URL（自定义尺寸）
        $largeAvatarUrl = $this->avatarService->getLink($user, 256);
        
        // 处理空用户（返回默认头像）
        $defaultAvatarUrl = $this->avatarService->getLink(null);
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'avatar_url' => $avatarUrl,
            'large_avatar_url' => $largeAvatarUrl,
        ]);
    }
}
```

## 配置

### 环境变量

- `DEFAULT_USER_AVATAR_URL`: 用作回退的默认头像图片 URL

### 用户实体要求

您的用户实体应该实现以下方法以与此包配合使用：

```php
<?php

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * 获取用户的自定义头像 URL
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * 获取用户的邮箱用于 Gravatar
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}
```

## 头像解析优先级

服务按以下顺序解析头像 URL：

1. **自定义头像**: 如果用户有自定义头像 URL，则返回该 URL
2. **Gravatar**: 如果用户有邮箱，则使用邮箱哈希生成 Gravatar URL
3. **默认头像**: 回退到配置的默认头像 URL

## API 参考

### AvatarServiceInterface

#### `getLink(?UserInterface $user, int $size = 128): string`

返回给定用户的头像 URL。

**参数:**
- `$user`: 用户对象（可以为 null 以获取默认头像）
- `$size`: 头像尺寸（像素，默认：128）

**返回:** 头像 URL 字符串

#### `syncAvatarToLocal(UserInterface $user): void`

将用户头像同步到本地存储（目前未实现）。

## 测试

运行测试套件：

```bash
./vendor/bin/phpunit packages/user-avatar-bundle/tests
```

## 贡献

有关详细信息，请参阅 [CONTRIBUTING.md](CONTRIBUTING.md)。

## 许可证

MIT 许可证。有关更多信息，请参阅 [License File](LICENSE)。