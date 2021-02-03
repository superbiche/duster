![Project Banner](https://raw.githubusercontent.com/tighten/duster/main/banner.png)
# Duster

Automatically apply Tighten's default code style for Laravel apps:

- PHPCS and PHPCS-Fixer, with PSR-12 + some special preferences
- Tighten's Tlint
- Maybe JS and CSS?

## Installation

You can install the package via composer:

```bash
composer require tightenco/duster
```

## Usage

To run individual lints:

```bash
./vendor/bin/duster-tlint-lint
./vendor/bin/duster-phpcs-lint
```

To run individual fixes:

```bash
./vendor/bin/duster-tlint-fix
./vendor/bin/duster-phpcs-fix
```

To lint everything at once:

```bash
./vendor/bin/duster-lint
```

To fix everything at once:

```bash
./vendor/bin/duster-fix
```

### Customizing the lints

To override the PHPCS lint, put your own `.phpcs.xml.dist` file in the root of your project.

To override the PHPCS-Fixer fix, put your own `.php_cs.dist` file in the root of your project.

To override the Tlint lint and fix, put your own `tlint.json` file in the root of your project.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tighten.co instead of using the issue tracker.

## Credits

- [Matt Stauffer](https://github.com/mattstauffer)
- [Tom Witkowski](https://github.com/devgummibeer) -- much of the idea and syntax for this was inspired by his `elbgoods/ci-test-tools` package
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
