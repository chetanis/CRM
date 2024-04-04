# CRM Installation Guide

Welcome to the CRM project! This guide will walk you through the steps required to install and set up the CRM application built with Laravel.

## Prerequisites

Before you begin, ensure you have the following prerequisites installed:

- [PHP](https://www.php.net/) (version 7.4 or higher)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) or [MariaDB](https://mariadb.org/)

## Installation Steps

1. **Clone the repository:**
```bash
git clone https://github.com/chetanis/CRM.git
```

2. **Navigate to the project directory:**

```bash
cd CRM
```

3. **Install PHP dependencies:**

```bash
composer install
```


4. **Set up environment variables:**
- Rename the `.env.example` file to `.env`:
  ```
  cp .env.example .env
  ```
- Edit the `.env` file and set your database connection details.
  ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
```

5. **Generate application key:**

```bash
php artisan key:generate
```

6. **Run database migrations:**

```bash
php artisan migrate
```


7. **Seed the database:**

```bash
php artisan db:seed
```

8. **Start the development server:**

```bash
php artisan serve
```


9. **Access the CRM:**
- Once the server is running, you can access the CRM application in your web browser by navigating to `http://localhost:8000` or the specified URL.

## Additional Configuration

If your CRM requires additional configuration steps, such as setting up authentication or configuring middleware, provide those instructions here.

## Support

If you encounter any issues during installation or have any questions, please contact [anis73chetouane@gmail.com](anis73chetouane@gmail.com).




