# Order Management System

A Laravel-based application to manage product orders, track stock levels, and handle order placements.

## Installation

### Prerequisites

-   PHP 8.0+
-   Composer
-   Laravel 11
-   SQLite or another supported database

### Steps

1. **Clone the Repository**

    ```sh
    git clone https://github.com/MMortymer/2solar.git
    cd 2solar
    ```

2. **Install Dependencies**

    ```sh
    composer install
    ```

3. **Set Up Environment**

    Copy the `.env.example` file to `.env` and update the environment variables as needed.

    ```sh
    cp .env.example .env
    ```

4. **Generate Application Key**

    ```sh
    php artisan key:generate
    ```

5. **Run Migrations**

    ```sh
    php artisan migrate
    ```

6. **Seed Database**

    ```sh
    php artisan db:seed
    ```

7. **Serve the Application**

    ```sh
    php artisan serve
    ```

## API Endpoints

### Place Order

-   **URL**: `/api/place-order`
-   **Method**: `POST`
-   **Body**:
    ```json
    {
        "items": [
            {
                "system_id": 1,
                "quantity": 2
            }
        ]
    }
    ```
-   **Success Response**:
    ```json
    {
        "message": "Order placed successfully"
    }
    ```
-   **Error Response**:
    ```json
    {
        "message": "Failed to place order: [error_message]"
    }
    ```

## File Paths

-   **Controllers**
    -   `app/Http/Controllers/OrderController.php`
-   **Models**

    -   `app/Models/System.php`
    -   `app/Models/Product.php`
    -   `app/Models/Order.php`

-   **Migrations**

    -   `database/migrations/xxxx_xx_xx_create_systems_table.php`
    -   `database/migrations/xxxx_xx_xx_create_products_table.php`
    -   `database/migrations/xxxx_xx_xx_create_orders_table.php`
    -   `database/migrations/xxxx_xx_xx_create_product_system_table.php`
    -   `database/migrations/xxxx_xx_xx_create_order_system_table.php`

-   **Seeders**

    -   `database/seeders/DatabaseSeeder.php`

-   **Templates**

    -   `resources/views/emails/low_stock.blade.php`

-   **Email Logs**
    -   `storage/logs/email.log`

## Testing

Run the test suite to ensure everything is functioning correctly:

```sh
php artisan test
```

## Configuration

-   Mail Configuration: Set up email settings in the .env file for local emails testing.

```
MAIL_MAILER=log
MAIL_LOG_CHANNEL=email
```

-   Stock Levels: Adjust initial stock values in DatabaseSeeder.php as needed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```

```
