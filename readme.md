# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Installation

This section contains instructions for installing the project in your local environment.

#### Begin Project

##### After pulling a project to your local repository for the first time, do the following:
1. cp .env.example .env (copy DOTENV config file so Lumen can use it)
    * also, configure .env file according to your needs
2. php composer.phar install (install the dependencies)
3. npm install (install node dependencies)
4. npm run dev (build scripts and SASS)
5. php artisan key:generate (generate application key)
6. php artisan migrate --seed (migrate and seed the database with dummy data)

##### After each consecutive pull
1. php composer.phar install
2. npm install
3. npm run dev
4. php artisan migrate --seed

#### NPM Scripts

For frontend development there are several options available for running NPM scripts:
* npm run dev (runs scripts and other files - as defined in webpack.mix.js - for development environment)
* npm run watch-poll (supports automatic build on Homestead machine when .vue file is saved with cmd+s)
* npm run hot (start webpack dev server with support of hot module replacement - that means you do not have to refresh a page for changes to be seen)
    * You should modify --output-public-path and --port switches to reflect your development URL
* npm run production (runs scripts and other files - as defined in webpack.mix.js - and applies production-specific loaders for production environment)

#### Database Setup

1. <span style="color:gray">[OPTIONAL] Set-up your DB_DATABASE database name</span>
2. <span style="color:gray">[OPTIONAL] If your DB_DATABASE is not set to default name run this command in your Homestead environment:
    * mysql -u DB_USERNAME -p
    * when prompted, type your DB_PASSWORD</span>
3. run the following command:
    * php artisan migrate --seed (seeds a database with "clean" migrations)
    * php artisan migrate:refresh --seed (roll-back and migrate the database)

##### Database and PhpStorm
If you are using PhpStorm and you want to see the Schema inside it, do the following:
1. Go to PhpStorm -> Preferences -> Tools -> Database
2. In "General" fill in the DB_DATABASE, DB_USERNAME and DB_PASSWORD
3. <span style="color:gray">[OPTIONAL] If you are using Homestead, go to "SSH/SSL" tab, check "Use SSH Tunnel" and fill in the fields below</span>

## Other References

#####[Swagger Library for API endpoint definition](http://swagger.io)
#####[Using VueJS with Lumen](https://github.com/stoutZero/vuejs-lumen-example)
#####[Deploying Laravel on Heroku - Official Docs](https://devcenter.heroku.com/articles/getting-started-with-laravel)
#####[Deploying Laravel on Heroku - for MySQL](https://mattstauffer.co/blog/laravel-on-heroku-using-a-mysql-database)

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
