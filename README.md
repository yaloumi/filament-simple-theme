![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-simple-theme/master/arts/3x1io-tomato-simple-theme.jpg)

# Filament Simple Theme

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-simple-theme/version.svg)](https://packagist.org/packages/tomatophp/filament-simple-theme)
[![License](https://poser.pugx.org/tomatophp/filament-simple-theme/license.svg)](https://packagist.org/packages/tomatophp/filament-simple-theme)
[![Downloads](https://poser.pugx.org/tomatophp/filament-simple-theme/d/total.svg)](https://packagist.org/packages/tomatophp/filament-simple-theme)

A simple theme for FilamentPHP: the user menu lives in the sidebar and the page content is an inset card.

## Version Compatibility

| Plugin | Filament | Laravel | PHP |
|--------|----------|---------|-----|
| 1.x    | 3.x      | 10.x / 11.x | 8.1+ |
| 5.x    | 5.x      | 12.x / 13.x | 8.2+ |

## Screenshots

![Dashboard](https://raw.githubusercontent.com/tomatophp/filament-simple-theme/master/arts/dashboard.png)
![User Menu](https://raw.githubusercontent.com/tomatophp/filament-simple-theme/master/arts/user-menu.png)
![Resource](https://raw.githubusercontent.com/tomatophp/filament-simple-theme/master/arts/resource.png)
![Dark Dashboard](https://raw.githubusercontent.com/tomatophp/filament-simple-theme/master/arts/dashboard-dark.png)
![Dark Resource](https://raw.githubusercontent.com/tomatophp/filament-simple-theme/master/arts/resource-dark.png)

## Installation

```bash
composer require tomatophp/filament-simple-theme
php artisan filament-simple-theme:install
```

Then register the plugin in `/app/Providers/Filament/AdminPanelProvider.php`:

```php
->plugin(\TomatoPHP\FilamentSimpleTheme\FilamentSimpleThemePlugin::make())
```

The theme is plain CSS registered with Filament assets: no Vite, Tailwind or npm step, and it works next to your own
`viteTheme()`. Run `php artisan filament:assets` after updating the package (the install command does it for you).

## How it works

- The panel topbar is turned off and Filament's own user menu moves to the sidebar footer, so everything plugins render
  around the user menu (language switchers, the theme switcher, custom menu items) keeps working.
- The sidebar sits on the page ground and the content becomes an inset card; light and dark mode are both styled.
- With [tomatophp/filament-tomatophp-theme](https://github.com/tomatophp/filament-tomatophp-theme) enabled it follows the brand colors.

Keep the topbar and its user menu, and only use the styling:

```php
->plugin(\TomatoPHP\FilamentSimpleTheme\FilamentSimpleThemePlugin::make()->sidebarUserMenu(false))
```

## Testing

```bash
composer test
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
