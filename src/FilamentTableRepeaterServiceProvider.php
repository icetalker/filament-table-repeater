<?php

namespace Icetalker\FilamentTableRepeater;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTableRepeaterServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->bootLoaders();
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-table-repeater')
            ->hasConfigFile()
            ->hasViews();
    }

    protected function bootLoaders()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-table-repeater');
    }
}
