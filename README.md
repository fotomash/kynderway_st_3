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
   - **Firebase** – `FIREBASE_CREDENTIALS` (path to the service account json)
5. Run the database migrations:
   ```bash
   php artisan migrate
   ```

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


