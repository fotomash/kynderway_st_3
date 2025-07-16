# Kynderway

Kynderway is a Laravel based platform for booking childcare. It provides a REST API for mobile clients as well as a traditional web interface. Payments are processed via Stripe and push notifications use Firebase.

## Local development

1. Clone the repository and install the PHP dependencies:
   ```bash
   composer install
   ```
2. Install the JavaScript dependencies:
   ```bash
   npm install
   ```
3. Copy the example environment file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Update `.env` with your local configuration:
   - **MySQL** – `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - **Stripe** – `STRIPE_SECRET` (your secret key)
   - **Firebase** – `FIREBASE_CREDENTIALS` should point to your Firebase service account JSON, e.g. `/path/to/firebase_credentials.json`
   - **Currency rates** – `CURRENCY_RATES_API_KEY` from your currency provider
   - **Checkr** – `CHECKR_SECRET` and optional `CHECKR_PACKAGE` to set the default background check package
   - **reCAPTCHA** – `GOOGLE_RECAPTCHA_KEY` and `GOOGLE_RECAPTCHA_SECRET` from the Google reCAPTCHA admin console. Missing values will prevent the reCAPTCHA widget from appearing.
5. Run the database migrations:
   ```bash
   php artisan migrate
   ```
6. Build the frontend assets:
   ```bash
   npm run build
   ```

> **Note** The compiled JavaScript under `public/js/` is ignored in version control. Run `npm run build` during deployment to generate these assets.

You can launch the application with the built in PHP server:
```bash
php artisan serve
```

### Using Docker
A `docker-compose.yml` is included that provides application, queue worker and MySQL services. Build and start the containers with:
```bash
docker-compose up --build
```

Prometheus and Grafana containers are also started for metrics at `http://localhost:9090` and `http://localhost:3000`.

The application exposes two endpoints for monitoring:

* `GET /metrics` – Prometheus format metrics
* `GET /health` – returns `{"status":"ok","database":"up"}` when the app and database are reachable

## Tests and linting

- Execute the test suite:
  ```bash
  php artisan test
  ```
- Run static analysis and coding style checks:
  ```bash
  composer lint
  ```
- Apply fixes and run PHPStan:
  ```bash
  composer lint:fix
  ```

## Continuous integration

GitHub Actions runs the workflow defined in `.github/workflows/ci.yml` on every push and pull request. The workflow sets up a MySQL service, installs dependencies, executes migrations and then runs `composer lint:phpstan`, `composer lint` and `php artisan test`.


## Test coverage and Cypress

Run the PHPUnit suite with artisan:
```bash
php artisan test
```
Generate an HTML coverage report:
```bash
php artisan test --coverage-html build/coverage
```
The coverage report will be available in `build/coverage`.

Execute the Cypress end-to-end tests:
```bash
npm run e2e
```
