## Important

Make sure to have php 8.1.0 installed in your machine.

## Install Dependencies

### run : composer install --ignore-platform-reqs

## Setup Environment
copy .env.example to new file call .env
Or using git bash command by run: `cp .env.example .env`

## Run Migrations

### Hint is very important run migrations with seeders sense we create a static Roles and Permissions

Run `php artisan migrate:fresh --seed`

## Passport

Run `php artisan passport:install`

## Development server

Run `php artisan serve`


## Running Feature tests

Run `php artisan test`

