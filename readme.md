[![LaravelVersion](https://img.shields.io/badge/Laravel-10-f56857.svg?style=flat-square)](https://laravel.com/docs/10.x/releases#laravel-10)
![PHPVersion](https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=flat-square)

> **Warning: This project is still in development**, constantly being optimized and isn't still stable enough to be used in production environments.

This project was created, and is maintained by [Budi Hermawan](https://github.com/realodix), and is an open-source issue tracking system for software development projects.

### Features
- **Written in [PHP](https://www.php.net/) and [Laravel 10](https://laravel.com/docs/10.x/releases#laravel-10).**
- **Modern and simple interface.**
- **Made with :heart: &amp; :coffee:.**


## Requirements
* All requirements by [Laravel](https://laravel.com/docs/installation#server-requirements) & dependencies - PHP >= 8.2, [Composer](https://getcomposer.org/) and such.


## Quick Start
### Installation Instructions
1. Run `composer install`.

2. Rename `.env.example` file to `.env` or run `cp .env.example .env`.

   Update `.env` to your specific needs. Don't forget to set `DB_USERNAME` and `DB_PASSWORD` with the settings used behind.

3. Run `php artisan key:generate`.

4. Run `php artisan migrate --seed`.

5. Run `php artisan serve`.

6. Login

   | Email               | Username | Password | Access       |
   |---------------------|----------|----------|--------------|
   | admin@realodix.test | admin    | admin    | Admin Access |
   | user@realodix.test  | user     | user     | User Access  |


### Compiling assets with Laravel Mix

#### Using Yarn
1. `yarn`
2. `yarn dev` or `yarn prod`

    *You can watch assets with `yarn watch`*

#### Using NPM
1. `npm install`
2. `npm run dev` or `npm run prod`

    *You can watch assets with `npm run watch`*

   Please note that this project uses Yarn as the package manager, so you can't find the package-lock.json file that is needed by NPM.

### Running Tests

From the projects root folder run
- `php artisan test`
- or `composer test`
- or `./vendor/bin/phpunit`


## laravel/laravel

- https://github.com/laravel/laravel/compare/25070a3ffb175c15b59cd7f12289a9648165bba3...10.x


## License
[MIT license](./LICENSE).
