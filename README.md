## About
This is an API service for a buddhist forum

## Requirement
- php^8.1
- MongoDB

## Installation
1. Run `cp .env.example .env`
2. Run `composer install`
3. Run `php artisan key:generate`
4. Run `php artisan migrate`
5. Run `php artisan db:seed`
6. Run `php artisan octane:start`
