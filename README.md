MTech POS System

A web-based Point of Sale (POS) and Inventory Management System developed using Laravel 12, PHP, and MySQL.

This project provides a centralized platform for managing products, customers, staff accounts, sales transactions, and inventory. It was developed as an academic project to demonstrate database integration, CRUD operations, authentication, file uploads, and web application deployment.

Live Website

Live Application: https://mtech-pos.ct.ws/

GitHub Repository: https://github.com/Lyon16/MTech-Final-Project

The live application requires a registered staff account to access management features. Login credentials are not publicly provided.

Technologies Used

Backend: PHP, Laravel 12

Database: MySQL

Frontend: Blade Templates, HTML, CSS, Bootstrap, JavaScript

Local Development: XAMPP

Version Control: Git and GitHub

Web Hosting: InfinityFree

Database Management: phpMyAdmin

System Features

1. Product Management

View available products.

Add new products.

Edit product information.

Delete products.

Upload product images.

Prepare uploaded images for display.

Track available stock quantities.

2. Customer Management

Create customer records.

View customer information.

Update customer details.

Delete customer records.

3. Staff Management

Create staff accounts.

View staff information.

Update staff account details.

Delete eligible staff accounts.

Upload and display staff avatars.

Automatically hash staff passwords.

Require a minimum of 12 characters for new passwords.

Restrict staff management to authorized administrators.

4. Authentication and Authorization

Staff login and logout.

Authentication-protected management pages.

Administrator-only Staff Management.

Restricted access for regular staff.

Session protection for logged-out users.

5. Sales Management

Record product sales.

Select a product and quantity.

Optionally assign a customer.

Support walk-in customers.

Calculate transaction totals.

Automatically deduct sold quantities from inventory.

Reject sales when requested quantities exceed available stock.

6. Sales History

Display recorded transactions, including:

Product

Customer, if applicable

Staff member who recorded the sale

Quantity sold

Total transaction price

Transaction date

Historical transaction totals remain unchanged when product prices are updated.

Database

The application uses MySQL with Laravel Eloquent models and relationships.

Main database tables include:

users

customers

products

sales

The application also uses Laravel database migrations to manage the database structure.

Local Installation

Prerequisites

PHP with the extensions required by the project

Composer

MySQL

XAMPP or another compatible local development environment

Git

Installation Steps

Clone the repository:

git clone https://github.com/Lyon16/MTech-Final-Project.git

Navigate to the project directory:

cd MTech-Final-Project

Install PHP dependencies:

composer install

Create a local environment configuration:

cp .env.example .env

On Windows, the file may also be copied manually.

Configure the local MySQL connection in .env.

Generate the Laravel application key:

php artisan key:generate

Create the required database and run migrations:

php artisan migrate

Start the Laravel development server:

php artisan serve

Open the local application using the address displayed by Laravel.

A staff account must be created through an authorized setup process before logging in.

Deployment

The application is deployed on InfinityFree using PHP and MySQL.

The production deployment includes:

Production environment configuration

Composer dependencies

Laravel application files

Protected application directories

Configured public entry point

MySQL database integration

Product and avatar image storage

Production credentials, application encryption keys, and environment configuration files are excluded from the GitHub repository.

Functional Testing

The following functions were tested on the live InfinityFree deployment:

Feature

Result

Administrator login

Passed

Regular staff login

Passed

Administrator access restrictions

Passed

Logout and session protection

Passed

Customer CRUD

Passed

Product CRUD

Passed

Staff creation and deletion

Passed

Product image upload

Passed

Staff avatar upload

Passed

Sales recording

Passed

Optional customer selection

Passed

Automatic inventory deduction

Passed

Insufficient-stock validation

Passed

Sales history

Passed

Historical transaction total preservation

Passed

Security Features

Password hashing through Laravel's Eloquent hashed attribute cast.

Server-side input validation.

Minimum 12-character staff password requirement.

Authentication middleware on protected routes.

Administrator authorization for staff management.

Protected product and avatar image-serving routes.

Environment files excluded from version control.

Project Purpose

This project demonstrates the practical application of web development concepts, relational database design, Laravel MVC architecture, authentication, CRUD operations, file handling, inventory management, and deployment to a live web hosting environment.

Project Status

Core development and deployment completed.

The application has passed its main functional tests and is accessible through its live InfinityFree website.