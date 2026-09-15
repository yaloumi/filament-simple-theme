<?php

namespace TomatoPHP\FilamentSimpleTheme;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Enums\UserMenuPosition;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Facades\FilamentAsset;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class FilamentSimpleThemePlugin implements Plugin
{
    use EvaluatesClosures;

    public const PACKAGE = 'tomatophp/filament-simple-theme';

    public const STYLESHEET = 'filament-simple-theme';

    protected bool | Closure $hasSidebarUserMenu = true;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-simple-theme';
    }

    /**
     * Hide the topbar and move the user menu (and everything rendered around it) to the sidebar footer.
     */
    public function sidebarUserMenu(bool | Closure $condition = true): static
    {
        $this->hasSidebarUserMenu = $condition;

        return $this;
    }

    public function hasSidebarUserMenu(): bool
    {
        return (bool) $this->evaluate($this->hasSidebarUserMenu);
    }

    public function register(Panel $panel): void
    {
        $panel->renderHook(
            PanelsRenderHook::HEAD_END,
            fn (): Htmlable => new HtmlString($this->renderStylesheet()),
        );

        if ($this->hasSidebarUserMenu()) {
            $panel
                ->topbar(false)
                ->userMenu(position: UserMenuPosition::Sidebar);
        }
    }

    public function boot(Panel $panel): void {}

    public function renderStylesheet(): string
    {
        return '<link rel="stylesheet" href="' . e($this->stylesheetHref()) . '" data-navigate-track />';
    }

    /**
     * Filament versions asset URLs by package version only; a content hash keeps CDNs from
     * serving a stale stylesheet after the CSS changes within the same version.
     */
    public function stylesheetHref(): string
    {
        $path = static::stylesheetPath();
        $hash = is_file($path) ? substr((string) md5_file($path), 0, 8) : null;

        return FilamentAsset::getStyleHref(self::STYLESHEET, self::PACKAGE) . ($hash ? "&h={$hash}" : '');
    }

    public static function stylesheetPath(): string
    {
        return __DIR__ . '/../resources/dist/' . self::STYLESHEET . '.css';
    }
}
