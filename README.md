# Customers API

> A Laravel With Rest-Full Best Practices

### Requirements

- PHP >= 8.0
- Composer
- Laravel 9.x
- Docker
- Docker Compose

### Installation

1. Clone the repository

    ```sh
    https://github.com/usyeimar/backend-exam-api.git
    ```

2. Install dependencies

    ```sh
    composer install
    ```

3. Create a copy of the .env file

    ```sh
    cp .env.example .env
    ```

4. Generate the application key

    ```sh
    php artisan key:generate
    ```

5. Run the migrations and seeders

    ```
    php artisan migrate --seed
    ```

6. Project comes with Passport include as the default authenticatin method. You should now install it using this command.

    ```
    php artisan passport:install
    ```

7. Copy-paste the generated secrets and IDs into your `.env` file like so.

    ```
    PASSPORT_PERSONAL_ACCESS_CLIENT_ID=1
    PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=mR7k7ITv4f7DJqkwtfEOythkUAsy4GJ622hPkxe6
    
    ```

8. Run the application
    
    ```sh
    php artisan serve
    ```

9.  Run Imsomnia API

    [![Run in Insomnia}](https://insomnia.rest/images/run.svg)](https://insomnia.rest/run/?label=Customer%20API%20&uri=https%3A%2F%2Fgithub.com%2Fusyeimar%2Fbackend-exam-api%2Fbackend-exam-api-collection.json)

### Code Quality Tools

- [Laravel Pint](https://github.com/laravel/pint)

### API Docs Tools

- [Laravel OpenAPI](https://github.com/vyuldashev/laravel-openapi)
- [Laravel Stoplight Elements](https://github.com/JustSteveKing/laravel-stoplight-elements)

### ✅ Tests execution

```sh
    php artisan test
```

