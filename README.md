# CRM System README

## Introduction

Welcome to our CRM (Customer Relationship Management) system! This private repository contains the source code and documentation for our CRM system, built using the Laravel PHP framework. Our CRM system is designed to help businesses manage their interactions with customers, track sales, and improve customer relationships.

## Features

- **Client Management**: Add, view, and manage client information.
- **Product Management**: Add and manage products.
- **User Management**: Three types of users: Admin, Superuser, and Simple User.
- **Role-Based Access Control (RBAC)**: Admins can do everything, including creating users. Superusers can manage products and perform actions available to Simple Users. Simple Users can add clients and commands.
- **Client Segmentation**: Each Simple User can only see their own clients.
- **Revenue Reports**: Track revenue numbers of clients.

## Getting Started

### Installation

1. Clone this repository to your local machine.
2. Install PHP and Composer if not already installed.
3. Navigate to the project directory and run `composer install` to install dependencies.
4. Set up your database and configure the connection in `.env` file.
5. Run database migrations and seed the database with initial data using `php artisan migrate --seed`.

### Usage

1. Start the Laravel development server using `php artisan serve`.
2. Access the CRM system through your web browser at the specified URL.
3. Log in using your credentials.
4. Explore the different features based on your user role.

## User Roles

- **Admin**: Can perform all actions, including creating users.
- **Superuser**: Can manage products in addition to Simple User actions.
- **Simple User**: Can add clients and commands. Can only see their own clients.

## Contributing

Contributions to this private repository are limited to authorized team members. If you find any bugs or have suggestions for new features, please contact the repository owner.

## License

This project is not open-source. All rights reserved.

## Support

If you have any questions or need assistance, please contact [anis73chetouane@gmail.com](mailto:anis73chetouane@gmail.com).
