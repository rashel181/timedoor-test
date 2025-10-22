# Timedoor Backend Programming Exam - Bookstore Management System

## Project Overview

This is a Laravel-based bookstore management system that allows users to view books, filter them by rating, search for books/authors, view top authors, and submit ratings. The system is built for John Doe's bookstore business to help him manage his book collection and provide customer recommendations.

## Features

-   **List of Books with Filter**: View books sorted by average rating with search and pagination
-   **Top 10 Most Famous Authors**: Display authors ranked by voter count (ratings > 5)
-   **Input Rating**: Submit ratings for books with proper validation

## Requirements

In this project, i use PHP 8.2 & Laravel 10.0

-   PHP 8.1 or higher
-   Laravel 10.0 or higher
-   MySQL database
-   Composer

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/rashel181/timedoor-test.git
cd timedoortest-app / open the cloned project folder
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration

Update your `.env` file with your MySQL database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=timedoortest_db
DB_USERNAME=root
DB_PASSWORD=

you can just fill in the database username as root, leave the password field blank, so you don't have to go through the lengthy credential entry process every time you open HeidiSQL or phpMyAdmin, because it's a local project and not deployed yet.
```

### 5. Create Database

Create a MySQL database named `timedoortest_db` (or your preferred name).

### 6. Run Migrations

```bash
php artisan migrate
```

if there's an option yes or no to create the project's database, type yes and then enter. (usually because we don't do the step 5)

### 7. Seed the Database

**IMPORTANT**: This will create a large amount of data (1000 authors, 3000 categories, 100,000 books, 500,000 ratings). This process may take several minutes, so we have to wait until all 4 seeders (especially RatingSeeder) status change from `running` to `done`, in my case this will take 7 minutes to generate 500K rows data. Generating over 100,000 data records takes several minutes and can't be done instantly. So, we need to wait a few minutes because in this project, I'm using a batch generating fake data with Faker in batches of 500 until it reach 500000 rating records. Because if we try to batch more than 500 data records at once or do it all directly, we'll get a "memory exhausted" error when generating that much data too quickly.

```bash
php artisan db:seed
```

### 8. Start the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000` or `http://127.0.0.1:8000/`

## Database Schema

### Tables Created:

-   **authors**: 1,000 fake authors
-   **categories**: 3,000 fake book categories
-   **books**: 100,000 fake books
-   **ratings**: 500,000 fake ratings (1-10 scale)

### Relationships:

-   Books belong to Authors and Categories
-   Ratings belong to Books
-   Authors have many Books
-   Books have many Ratings

## Usage

### 1. List of Books Page (`/`)

-   Shows books sorted by average rating (highest first)
-   Filter by number of results (10-100) (need to click submit button after that, So that the data changes according to how long it will be displayed for example, 20 records.)
-   Search by book title or author name

### 2. Top Authors Page (`/authors/top`)

-   Shows top 10 authors by voter count
-   Only counts ratings > 5
-   Ordered by total voters

### 3. Input Rating Page (`/ratings/create`)

-   Select author from dropdown
-   Select book from dropdown (filtered by author)
-   Select rating (1-10)
-   Validates that book belongs to selected author

## Technical Details

### Performance Optimizations:

-   Batch processing for large data seeding
-   Efficient database queries with proper joins
-   Pagination for large datasets

### Data Generation:

-   Uses Faker library for realistic fake data
-   Proper foreign key relationships
-   Random but valid data distribution

## Notes for Evaluation:

-   No caching is used as per requirements
-   All data is generated using Faker
-   Simple HTML/CSS interface (no complex styling as requested)
-   Focus on backend logic and Laravel implementation

## Troubleshooting

### If seeding fails:

1. Ensure MySQL has enough memory allocated
2. Increase `max_execution_time` in php.ini
3. Run seeders individually if needed:

```bash
php artisan db:seed --class=AuthorSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=BookSeeder
php artisan db:seed --class=RatingSeeder
```

### If you encounter memory issues:

-   Increase PHP memory limit in php.ini (search the line `memory_limit` in php.ini. you can access thif file for example if you're using laragon, go to PHP section, and then in the drop down, there will be an option called php.ini)
-   Consider running seeders in smaller batches (we change this number in RatingSeeder, change the number in variable $batch from 500 to number lower than 500. Because in my case, it got stucked and only generate / stopped at around 89000 rows data, so i change the batch number from 1000 to 500)

## Project Structure

```
app/
├── Http/Controllers/
├── Models/
database/
├── factories/
├── migrations/
└── seeders/
resources/views/
routes/web.php
```
