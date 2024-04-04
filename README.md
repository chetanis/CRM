## Language Selection

- [English](#english)
- [français](#french)

## English

# CRM Installation Guide

Welcome to the CRM project! This guide will walk you through the steps required to install and set up the CRM application built with Laravel.

## Prerequisites

Before you begin, ensure you have the following prerequisites installed:

- [PHP](https://www.php.net/) (version 8.1 or higher)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) (version 5.7 or higher)or [MariaDB](https://mariadb.org/) (version 10.5.7 or higher)

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

## User Credentials

In this CRM, three types of users are pre-defined: **admin**, **superuser**, and **user**. Below are the default credentials for each user role:

- **Admin User**:
  - Username: admin
  - Password: 12345678

- **Superuser User**:
  - Username: superuser
  - Password: 12345678

- **Regular User**:
  - Username: user
  - Password: 12345678

## Support

If you encounter any issues during installation or have any questions, please contact [anis73chetouane@gmail.com](anis73chetouane@gmail.com).

## French

# Guide d'installation du CRM

Bienvenue dans le projet CRM ! Ce guide vous guidera à travers les étapes nécessaires pour installer et configurer l'application CRM construite avec Laravel.

## Prérequis

Avant de commencer, assurez-vous d'avoir les prérequis suivants installés :

- [PHP](https://www.php.net/) (version 8.1 ou supérieure)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) (version 5.7 ou supérieure) ou [MariaDB](https://mariadb.org/) (version 10.5.7 ou supérieure)

## Étapes d'installation

1. **Cloner le dépôt :**
```bash
git clone https://github.com/chetanis/CRM.git
```

2. **Naviguer vers le répertoire du projet :**

```bash
cd CRM
```

3. **Installer les dépendances PHP :**

```bash
composer install
```


4. **Configurer les variables d'environnement :**
- Renommez le fichier `.env.example` en `.env` :
  ```
  cp .env.example .env
  ```
- Éditez le fichier `.env` et configurez les détails de connexion à votre base de données.
  ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
  ```

5. **Générer la clé d'application :**

```bash
php artisan key:generate
```

6. **Exécuter les migrations de base de données :**

```bash
php artisan migrate
```


7. **Alimenter la base de données :**

```bash
php artisan db:seed
```

8. **Démarrer le serveur de développement :**

```bash
php artisan serve
```


9. **Accéder au CRM ::**
- Une fois le serveur démarré, vous pouvez accéder à l'application CRM dans votre navigateur en vous rendant à l'adresse `http://localhost:8000` ou à l'URL spécifiée.

## Identifiants des utilisateurs

Dans ce CRM, trois types d'utilisateurs sont pré-définis : **admin**, **superuser** et **user**. Voici les identifiants par défaut pour chaque rôle d'utilisateur :

- **Admin User**:
  - Username: admin
  - Password: 12345678

- **Superuser User**:
  - Username: superuser
  - Password: 12345678

- **Regular User**:
  - Username: user
  - Password: 12345678

## Support

Si vous rencontrez des problèmes lors de l'installation ou si vous avez des questions, veuillez contacter [anis73chetouane@gmail.com](anis73chetouane@gmail.com).
