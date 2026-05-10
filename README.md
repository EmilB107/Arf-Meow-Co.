# Arf & Meow Co. — Product Catalog

A Laravel 12 product catalog management system with role-based access control for Super Admins, Admins, and Project Managers.

## Prerequisites

Before you start, make sure you have the following installed on your machine:

| Tool | Version | Notes |
|------|---------|-------|
| PHP | 8.2+ | Easiest via [Laragon](https://laragon.org/) or [XAMPP](https://www.apachefriends.org/) on Windows |
| Composer | Latest | [getcomposer.org](https://getcomposer.org/download/) |
| Node.js | LTS (18+) | [nodejs.org](https://nodejs.org/) — includes npm |
| MySQL | 8.0+ | Comes bundled with Laragon or XAMPP |

> **Recommended for Windows:** Use [Laragon](https://laragon.org/) — it bundles PHP, MySQL, and a terminal in one installer.

## Installing Prerequisites (Windows)

### Laragon (PHP + MySQL)

1. Download Laragon from [laragon.org](https://laragon.org/) and run the installer
2. Launch Laragon and click **Start All** to start Apache and MySQL

### Composer

1. Download the installer from [getcomposer.org/download](https://getcomposer.org/download/)
2. Run the installer — when it asks for the PHP executable, point it to Laragon's PHP:
   ```
   C:\laragon\bin\php\php8.2+\php.exe
   ```
3. Check **"Add this PHP to your PATH"** so you can run `php` from any terminal
4. Leave **"Use a proxy server"** unchecked (unless your network requires one)
5. Finish the installation — open a new terminal and run `composer --version` to verify

### Enable required PHP extensions

Before running `composer install`, make sure these extensions are enabled in your `php.ini`:

1. Open `C:\laragon\bin\php\php8.2+\php.ini` in a text editor
2. Find these lines and remove the semicolon at the start of each:
   ```
   extension=fileinfo
   extension=pdo_mysql
   extension=mysqli
   extension=pdo_sqlite
   ```
   > `pdo_sqlite` is only required for running tests — the app itself uses MySQL.
3. Save the file and restart Laragon (**Stop All** → **Start All**)

### Node.js

1. Download the LTS version from [nodejs.org](https://nodejs.org/)
2. Run the installer with default settings
3. Verify with `node --version` and `npm --version` in a terminal

## Setup

### 1. Clone the repository

```bash
git clone https://github.com/jkrustia/ProductCatalog---Final_Project.git
cd ProductCatalog---Final_Project
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

```bash
cp .env.example .env         # Linux/Mac
copy .env.example .env       # Windows Command Prompt
```

Then open `.env` and fill in your MySQL database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arf_meow
DB_USERNAME=root
DB_PASSWORD=
```

> **Note:** Make sure your MySQL server is running and the database (`arf_meow`) already exists. Create it in **HeidiSQL** (Laragon's database manager — click **Database** in Laragon) by right-clicking the left panel → **Create new** → **Database**, name it `arf_meow`, and set the collation to `utf8mb4_general_ci`.

### 4. Generate app key

```bash
php artisan key:generate
```

### 5. Run migrations and seed the database

```bash
php artisan migrate
php artisan db:seed
```

### 6. Create the storage symlink (for product images)

```bash
php artisan storage:link
```

> **Note:** If you get a message saying the link already exists, that's fine — skip it.

## Running Tests

The test suite uses an in-memory SQLite database — no extra setup needed beyond enabling `pdo_sqlite` (see Prerequisites).

```bash
php artisan test
```

63 tests across auth, registration, role redirects, product CRUD, and access control.

## Running the Dev Server

```bash
composer run dev
```

This starts four processes at once: the Laravel server, queue worker, log watcher, and Vite (frontend assets). Open **http://localhost:8000** in your browser.

## Default Accounts

After seeding, you can log in with these accounts:

| Role            | Email                  | Password | Redirects To  |
|-----------------|------------------------|----------|---------------|
| Super Admin     | superadmin@example.com | password | `/superadmin` |
| Admin           | admin@example.com      | password | `/dashboard`  |
| Project Manager | PM@example.com         | password | `/dashboard`  |

## Features

- Product management (create, view, edit, delete)
- Category & subcategory management
- Inventory tracking with stock status (In Stock / Low Stock / Out of Stock)
- SKU and price management
- Product image uploads
- Role-based access: Super Admin, Admin, Project Manager
- User management (Super Admin only)
- User signup

## Role Permissions

| Feature                | Super Admin | Admin | Project Manager |
|------------------------|:-----------:|:-----:|:---------------:|
| View products          |     Yes     |  Yes  |       Yes       |
| Create / Edit products |     Yes     |  Yes  |       No        |
| Delete products        |     Yes     |  Yes  |       No        |
| Manage categories      |     Yes     |  Yes  |       No        |
| Manage users           |     Yes     |  No   |       No        |

## Deploying to Render

> **Note:** The free tier web service sleeps after 15 minutes of inactivity and takes ~30 seconds to wake on the next request. Uploaded product images do not persist across deploys (ephemeral filesystem).

### 1. Connect your repository

Create a [Render](https://render.com) account and connect your GitHub repository.

### 2. Deploy via Blueprint

In the Render dashboard click **New → Blueprint**, select your repo, and confirm. Render reads `render.yaml` and creates the web service and PostgreSQL database automatically.

### 3. Set the app key

Go to your web service → **Environment** and add:

```
APP_KEY=<paste the value from your local .env>
```

The value starts with `base64:`.

### 4. Trigger a deploy

Click **Manual Deploy → Deploy latest commit** if one hasn't started automatically. After this, every push to `main` redeploys automatically.

The app seeds the database on startup — default accounts are created on first boot.

> **Note:** If Render's free PostgreSQL tier is unavailable, create a free database at [neon.tech](https://neon.tech) and set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` manually in the Render dashboard.
