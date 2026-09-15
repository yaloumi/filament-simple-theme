<?php

namespace TomatoPHP\FilamentSimpleTheme\Console;

use Illuminate\Console\Command;

class FilamentSimpleThemeInstall extends Command
{
    protected $signature = 'filament-simple-theme:install';

    protected $description = 'Publish the Filament Simple Theme stylesheet';

    public function handle(): int
    {
        $this->callSilently('filament:assets');

        $this->components->info('Filament Simple Theme installed successfully.');

        return self::SUCCESS;
    }
}
