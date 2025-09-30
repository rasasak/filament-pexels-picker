<?php

namespace Rasasak\PexelsPicker;

use BladeUI\Icons\Factory;
use Filament\Forms\Components\BaseFileUpload;
use Livewire\Livewire;
use Rasasak\PexelsPicker\Actions\PexelsPickerAction;
use Rasasak\PexelsPicker\Livewire\PexelsPickerComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PexelsPickerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'pexels-picker';

    public static string $viewNamespace = 'pexels-picker';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasViews();
    }

    public function packageRegistered()
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('up', [
                'path' => __DIR__ . '/../resources/icons',
                'prefix' => 'up',
            ]);
        });
    }

    public function packageBooted(): void
    {
        BaseFileUpload::configureUsing(function (BaseFileUpload $component) {
            $component->extraAlpineAttributes(PexelsPickerAction::getExtraAlpineAttributes(...));
        });

        Livewire::component('pexels-picker-component', PexelsPickerComponent::class);
    }
}
