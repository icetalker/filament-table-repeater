
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Repeater Component in Table layout for Filament Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/icetalker/filament-table-repeater.svg?style=flat-square)](https://packagist.org/packages/icetalker/filament-table-repeater)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/icetalker/filament-table-repeater/run-tests?label=tests)](https://github.com/icetalker/filament-table-repeater/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/icetalker/filament-table-repeater/Check%20&%20fix%20styling?label=code%20style)](https://github.com/icetalker/filament-table-repeater/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/icetalker/filament-table-repeater.svg?style=flat-square)](https://packagist.org/packages/icetalker/filament-table-repeater)

This is a package for Filament form component. Extends from Repeater, but display in Table Layout.

![image](/screenshots/screen-shot.png)

## Installation

You can install the package via composer:

```bash
composer require icetalker/filament-table-repeater
```

You can publish the views using

```bash
php artisan vendor:publish --tag="filament-table-repeater"
```

## Usage

```php
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

protected function getFormSchema(): array
{
    return [
        ...
        Forms\Components\Grid::make(1)->schema([

            TableRepeater::make('items')
                ->relationship('items')
                ->schema([
                    Forms\Components\TextInput::make('product'),
                    ...
                ])
                ->collapsible()
                ->defaultItems(3),

        ]),

    ];
}
```

> Since this component extends from `Filament\Forms\Components\Repeater`, you can use most of its methods, except for a few methods like `inset()`, `grid()`, `columns()`. 

## Other method

### colStyles

To customize styles for each cell, you can pass an array of component name as key and css style as value to `colStyles()`.  See example below:

```php
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

protected function getFormSchema(): array
{
    return [
        ...
        Forms\Components\Grid::make(1)->schema([

            TableRepeater::make('items')
                ->relationship('items')
                ->schema([
                    Forms\Components\TextInput::make('product'),
                    Forms\Components\TextInput::make('quantity'),
                    ...
                ])
                ->colStyles([
                    'product' => 'color: #0000ff; width: 250px;',
                ]),

        ]),

    ];
}
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Martin Hwang](https://github.com/icetalker)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
