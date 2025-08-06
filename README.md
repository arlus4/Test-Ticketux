# Test Ticketux

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
    <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
    <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

## About Test Ticketux

Test Ticketux is a comprehensive accounting system built with Laravel framework. This application provides a complete solution for managing financial transactions, chart of accounts, categories, and generating financial reports.

### Features

-   **Dashboard**: Overview of financial statistics and quick actions
-   **Category Management**: Create and manage transaction categories
-   **Chart of Accounts (COA)**: Manage account codes and their relationships
-   **Transaction Management**: Record debit and credit transactions
-   **Profit/Loss Reports**: Generate monthly financial reports
-   **Excel Export**: Export reports to Excel format
-   **Responsive Design**: Bootstrap-based UI that works on all devices

### Key Capabilities

-   Complete CRUD operations for all entities
-   Relational database with foreign key constraints
-   Advanced reporting with category-wise breakdown
-   Data export functionality
-   Form validation and error handling
-   Modern, intuitive user interface

## Installation

### Requirements

-   PHP 8.2 or higher
-   Composer
-   MySQL/PostgreSQL/SQLite
-   Node.js & NPM (for asset compilation)

### Setup Instructions

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd test-ticketux
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database setup**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Start the application**
    ```bash
    php artisan serve
    ```

## Usage

### Main Modules

1. **Categories**: Manage transaction categories (Income, Expenses, etc.)
2. **Chart of Accounts**: Define account codes and link them to categories
3. **Transactions**: Record financial transactions with debit/credit entries
4. **Reports**: Generate and export profit/loss reports

### Navigation

-   Access the dashboard at `/`
-   Manage categories at `/kategoris`
-   Manage COA at `/coas`
-   Record transactions at `/transaksis`
-   View reports at `/reports/profit-loss`

## Technology Stack

-   **Backend**: Laravel 12.x
-   **Frontend**: Bootstrap 5, FontAwesome, jQuery
-   **Database**: MySQL (configurable)
-   **Export**: Maatwebsite Excel package

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
