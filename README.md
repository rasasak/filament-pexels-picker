# Pexels Picker for Filament

Pexels gallery for Filament. Search and pick any image from Pexels.com, specify which size to use.

Forked from mansoor/filament-unsplash-picker

## Installation

You can install the plugin via composer:

```bash
composer require mansoor/filament-unsplash-picker
```

Add Pexels API key to `config/services.php`

```php
'pexels' => [
    'key' => env('PEXELS_API_KEY'),
],
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme add the plugin's views to your theme css file.

```css
@source '../../../../vendor/rasasak/pexels-unsplash-picker/resources/**/*.blade.php';
```

Add plugin views to your theme css file is the only change you need to upgrade to 4.x.

## Usage

Just add the `PexelsPickerAction` to your FileUpload Field's action.

```php
use Rasasak\PexelsPicker\Actions\PexelsPickerAction;

Forms\Components\FileUpload::make('featured_image')
    ->image()
    ->hintAction(
        PexelsPickerAction::make()
    )
```

This plugin also supports all the features for [Spatie Media Libaray Plugin](https://filamentphp.com/plugins/filament-spatie-media-library)

```php
SpatieMediaLibraryFileUpload::make('featured_image')
    ->image()
    ->hintAction(
        PexelsPickerAction::make()
    )
```

## Specifying Image Size

You can specify which image size to use.

```php
PexelsPickerAction::make()
    ->regular()
```

**Available sizes:**

-   `->original()`
-   `->large2x()`
-   `->large()`
-   `->medium()`
-   `->small()`
-   `->landscape()`
-   `->portrait()`
-   `->tiny()`

## Choose multiple photos

If you add `->multiple()` to your FileUpload field, the plugin will allow you to pick multiple images. The plugin respects the validation so you will only be able to pick max files set by the FileUpload field.

```php
FileUpload::make('featured_image')
    ->multiple() // This will indicate the plugin to allow the user to pick multiple files
    ->hintAction(
        PexelsPickerAction::make()
    )
```

## Specifying Per Page

You may specify how many photos to show per page by appending `->perPage()` method.

```php
PexelsPickerAction::make()
    ->perPage(20)
```

## Enable/Disable Square Mode

You can choose to dispaly images in square which uses `aspect-square` class from Tailwind CSS or disable it to display images in original height.

```php
PexelsPickerAction::make()
    ->useSquareDisplay(false)
```

### Default search

You may set the default search input.

```php
PexelsPickerAction::make()
    ->defaultSearch('Hello world')
```

You can also pass a custom closure to get search input from a field and return the search string.

```php
PexelsPickerAction::make()
    ->defaultSearch(fn (Get $get) => $get('title'))
```

### Hooks

Similar to core Filament, Unsplash picker provides two hooks `beforeUpload` and `afterUpload` to let you use Unsplash data.

```php
PexelsPickerAction::make()
    ->afterUpload(function (array $data) {
        dd($data);
    })
```

## Customization

The `PexelsPickerAction` is simple Filament Form Action and you may override all the available methods. The Image picker component is a Livewire component, which is easy to extend.

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-pexels-picker-views"
```

> [!IMPORTANT]
> When defining the `extraAlpineAttributes` method for `SpatieMediaLibraryFileUpload` or `FileUpload` field, make sure to merge the Alpine attributes from `PexelsPickerAction`.

```php
SpatieMediaLibraryFileUpload::make('media')
    ->extraAlpineAttributes(function ($component) {
        return [
            'custom-attribute' => 'custom-attribute-value-goes-here',
            ...PexelsPickerAction::getExtraAlpineAttributes($component),
        ];
    })
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Mansoor Ahmed](https://github.com/mansoorkhan96)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
