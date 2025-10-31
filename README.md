# User Avatar Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/user-avatar-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/user-avatar-bundle?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)
[![License](https://img.shields.io/packagist/l/tourze/user-avatar-bundle?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/user-avatar-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/user-avatar-bundle)

A Symfony bundle that provides user avatar services with support for custom avatars, Gravatar integration, and fallback to default avatars.

## Features

- **Custom Avatar Support**: Display user-uploaded avatars when available
- **Gravatar Integration**: Automatically generates Gravatar URLs based on user email
- **Default Avatar Fallback**: Shows default avatar when user has no custom avatar or email
- **Configurable Sizes**: Supports different avatar sizes (default 128px)
- **Extensible Interface**: Easy to extend with custom avatar implementations

## Installation

```bash
composer require tourze/user-avatar-bundle
```

## Quick Start

1. Add the bundle to your `config/bundles.php`:

```php
<?php

return [
    // ... other bundles
    Tourze\UserAvatarBundle\UserAvatarBundle::class => ['all' => true],
];
```

2. Configure the default avatar URL in your environment:

```bash
# .env
DEFAULT_USER_AVATAR_URL=https://example.com/default-avatar.png
```

3. Use the avatar service in your application:

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
        // Get user avatar URL with default size (128px)
        $avatarUrl = $this->avatarService->getLink($user);
        
        // Get user avatar URL with custom size
        $largeAvatarUrl = $this->avatarService->getLink($user, 256);
        
        // Handle null user (returns default avatar)
        $defaultAvatarUrl = $this->avatarService->getLink(null);
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'avatar_url' => $avatarUrl,
            'large_avatar_url' => $largeAvatarUrl,
        ]);
    }
}
```

## Configuration

### Environment Variables

- `DEFAULT_USER_AVATAR_URL`: URL to the default avatar image used as fallback

### User Entity Requirements

Your user entity should implement the following methods to work with this bundle:

```php
<?php

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * Get user's custom avatar URL
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * Get user's email for Gravatar
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}
```

## Avatar Resolution Priority

The service resolves avatar URLs in the following order:

1. **Custom Avatar**: If user has a custom avatar URL, it's returned
2. **Gravatar**: If user has an email, generates Gravatar URL with the email hash
3. **Default Avatar**: Falls back to the configured default avatar URL

## API Reference

### AvatarServiceInterface

#### `getLink(?UserInterface $user, int $size = 128): string`

Returns the avatar URL for the given user.

**Parameters:**
- `$user`: User object (can be null for default avatar)
- `$size`: Avatar size in pixels (default: 128)

**Returns:** Avatar URL string

#### `syncAvatarToLocal(UserInterface $user): void`

Synchronizes user avatar to local storage (currently not implemented).

## Testing

Run the test suite:

```bash
./vendor/bin/phpunit packages/user-avatar-bundle/tests
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.