<?php

namespace TomatoPHP\FilamentSimpleTheme;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentSimpleTheme\Console\FilamentSimpleThemeInstall;

class FilamentSimpleThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            FilamentSimpleThemeInstall::class,
        ]);
    }

    public function boot(): void
    {
        // Loaded on request so only panels that register the plugin receive the theme.
        FilamentAsset::register([
            Css::make(FilamentSimpleThemePlugin::STYLESHEET, FilamentSimpleThemePlugin::stylesheetPath())->loadedOnRequest(),
        ], package: FilamentSimpleThemePlugin::PACKAGE);
    }
}
