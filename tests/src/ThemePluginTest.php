<?php

use Filament\Enums\UserMenuPosition;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use TomatoPHP\FilamentSimpleTheme\FilamentSimpleThemePlugin;
use TomatoPHP\FilamentSimpleTheme\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('registers the plugin on the panel', function () {
    expect(Filament::getPanel('admin')->getPlugin('filament-simple-theme'))
        ->toBeInstanceOf(FilamentSimpleThemePlugin::class);
});

it('moves the user menu to the sidebar', function () {
    $panel = Filament::getPanel('admin');

    expect($panel->hasTopbar())->toBeFalse()
        ->and($panel->getUserMenuPosition())->toBe(UserMenuPosition::Sidebar);
});

it('can keep the topbar and its user menu', function () {
    $panel = Panel::make()->id('plain')->path('plain');

    FilamentSimpleThemePlugin::make()->sidebarUserMenu(false)->register($panel);

    expect($panel->hasTopbar())->toBeTrue()
        ->and($panel->getUserMenuPosition())->toBe(UserMenuPosition::Topbar);
});

it('registers the stylesheet with Filament assets', function () {
    expect(FilamentAsset::getStyleHref(FilamentSimpleThemePlugin::STYLESHEET, FilamentSimpleThemePlugin::PACKAGE))
        ->toContain('filament-simple-theme.css')
        ->and(FilamentSimpleThemePlugin::stylesheetPath())->toBeFile();
});

it('injects the stylesheet into the panel head with a content hash', function () {
    $panel = Filament::getPanel('admin');
    Filament::setCurrentPanel($panel);
    $panel->boot();

    $hash = substr(md5_file(FilamentSimpleThemePlugin::stylesheetPath()), 0, 8);

    expect(FilamentView::renderHook(PanelsRenderHook::HEAD_END)->toHtml())
        ->toContain('filament-simple-theme.css')
        ->toContain("h={$hash}");
});

it('renders the dashboard with the user menu in the sidebar', function () {
    actingAs(User::create(['name' => 'Fady Mondy', 'email' => 'fady@example.com', 'password' => bcrypt('password')]));

    get('/admin')
        ->assertOk()
        ->assertSee('filament-simple-theme.css', escape: false)
        ->assertSee('fi-sidebar-footer', escape: false)
        ->assertSee('fi-user-menu', escape: false)
        ->assertDontSee('fi-topbar-ctn', escape: false);
});

it('keeps what plugins render next to the user menu, like language switchers', function () {
    FilamentView::registerRenderHook(
        PanelsRenderHook::USER_MENU_BEFORE,
        fn (): string => '<div id="language-switch-marker">EN</div>',
    );

    actingAs(User::create(['name' => 'Fady Mondy', 'email' => 'fady@example.com', 'password' => bcrypt('password')]));

    get('/admin')
        ->assertOk()
        ->assertSee('language-switch-marker', escape: false);
});

it('publishes the stylesheet on install', function () {
    $this->artisan('filament-simple-theme:install')->assertSuccessful();

    expect(public_path('css/tomatophp/filament-simple-theme/filament-simple-theme.css'))->toBeFile();
});
