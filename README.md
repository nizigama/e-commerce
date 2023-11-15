# Saint May Shop API

#### A Laravel based API for an e-commerce SPA


## Initial Setup
- Copy .env file
    ```
    cp .env.example .env
    ```
- Get composer dependencies
    ```
    docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs
    ```
- Start the project
    ```
    vendor/bin/sail up
    ```
- Generate the app key
    ```
    vendor/bin/sail artisan key:generate
    ```
- Run migrations
    ```
    vendor/bin/sail artisan migrate:fresh
    ```
- Seed the database with fake products (OPTIONAL)
    ```
    vendor/bin/sail artisan db:seed
    ```


## Start

To start the project, run:
```
vendor/bin/sail up
```

## Testing

To run the tests, run:
```
vendor/bin/sail artisan test
```
