# LaravelAuth0Migrator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Tests](https://github.com/KUHdo/laravel-auth0-migrator/actions/workflows/run-tests.yml/badge.svg)](https://github.com/KUHdo/laravel-auth0-migrator/actions/workflows/run-tests.yml)
[![normalize composer.json](https://github.com/KUHdo/laravel-auth0-migrator/actions/workflows/composer-normalize.yml/badge.svg)](https://github.com/KUHdo/laravel-auth0-migrator/actions/workflows/composer-normalize.yml)

This `laravel-auth0-migrator` package helps out with the migration of a standard laravel setup. 
Basically this packages get the needed API tokens as input.  
Does a bulk user import to the new auth0 database via some [guzzle](https://docs.guzzlephp.org/en/stable/) requests.
After the migration is verified and done the package could be removed and is not needed furthermore and can be removed.

## Installation

Via Composer

``` bash
$ composer require kuhdo/laravel-auth0-migrator
```
In most cases it makes sense to read the documentation at auth0´s side. You should take a look into the [laravel tutorial](https://auth0.com/docs/quickstart/webapp/laravel/01-login).

## Prerequisites
Follow the steps of auth0 [here](https://auth0.com/docs/manage-users/user-migration/bulk-user-imports#prerequisites).
Explicitly you'll the API tokens for the auth0 database to be filled with the existing local laravel users.  
  
**You need the following env vars:**
- `AUTH0_DOMAIN=`
- `AUTH0_CLIENT_ID=`
- `AUTH0_CLIENT_SECRET=`
- `AUTH0_AUDIENCE=`
  
**Optional:**
-  `ORGANIZATION_ID=`

## Usage

https://auth0.com/docs/manage-users/user-migration/bulk-user-imports

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email dev@kuhdo.de instead of using the issue tracker.

## Credits

- [Arne Bartelt][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/kuhdo/laravel-auth0-migrator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/kuhdo/laravel-auth0-migrator.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/kuhdo/laravel-auth0-migrator/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/kuhdo/laravel-auth0-migrator
[link-downloads]: https://packagist.org/packages/kuhdo/laravel-auth0-migrator
[link-travis]: https://travis-ci.org/kuhdo/laravel-auth0-migrator
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/kuhdo
[link-contributors]: ../../contributors
