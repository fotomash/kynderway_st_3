# Contributing to Kynderway

Thank you for helping improve Kynderway! This document explains the typical workflow for local development, coding standards and how to run tests. Please read this guide before opening a pull request.

## Setup

1. Install PHP dependencies:
   ```bash
   composer install
   ```
2. Install JavaScript dependencies:
   ```bash
   npm install
   ```
3. (Optional) Use Docker to start MySQL and application services:
   ```bash
   docker-compose up --build
   ```

After installing dependencies you may copy `.env.example` to `.env` and generate an application key with `php artisan key:generate`. Update the environment file with your local configuration and run `php artisan migrate` to prepare the database.

## Coding standards

The project follows PSR-12 via **PHP CS Fixer** and uses **PHPStan** for static analysis. Run the checks with:
```bash
composer lint
```
Automatically fix formatting issues and run PHPStan with:
```bash
composer lint:fix
```

## Running tests

Execute the PHPUnit suite:
```bash
php artisan test
```
HTML coverage can be generated with `php artisan test --coverage-html build/coverage` and Cypress tests with `npm run e2e`.

## Continuous integration

Every push and pull request triggers the workflow defined in `.github/workflows/ci.yml`. The CI job installs dependencies, runs migrations and then executes `composer lint:phpstan`, `composer lint` and `php artisan test`. Please ensure these commands pass locally before submitting a pull request.
