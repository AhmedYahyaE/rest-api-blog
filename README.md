# ClickShare E-Commerce Product Management Feature Application

This is a Blogging Platform RESTful application built with **Laravel 11** with the help of Tymon JWT-Auth package for API authentication.


## Technical Features

This appliction features API Resource classes, Resource Collection classes, Factories & Seeders, Form Request classes, API Versioning, Unit Tests, and API Documentation using L5 Swagger package.
API endpoints tested using Postman.


## Installation Instructions

Follow the steps below to set up and run the application locally.


### Steps to Install

1. **Clone the repository**:
    ```bash
    git clone https://github.com/AhmedYahyaE/rest-api-blog.git
    cd rest-api-blog-main
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Set up the environment file**:
    Copy `.env.example` to `.env`:
    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**:  
    This step generates a unique application key for encryption:  
    ```bash
    php artisan key:generate
    ```

5. **Configure the database**:
    Open the `.env` file and set your database credentials:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

6. **Migrate the database**:
    Run the migrations to create the necessary tables:
    ```bash
    php artisan migrate
    ```

7. **Seed the database**:
    ```bash
    php artisan db:seed
    ```

8. **Install frontend dependencies**:
    ```bash
    npm install
    ```

9. **Build Vite assets** (for frontend):
    ```bash
    npm run build
    ```

10. **Start the Laravel development server**:
    ```bash
    php artisan serve
    ```

Now, your application should be running locally at `http://localhost:8000`. To experiment with the application, start with registering as a new user using the api/v1/auth/register endpoint, then login using the /api/v1/auth/login endpoint.

## Blog API Documentation:

You can access this applications API Documentation using L5 Swagger documentation running locally on `http://localhost:8000/api/documentation`.

Note : Make sure to include the "Accept: application/json" Header with all your requests.

Check my Postman Collection of the API on: https://web.postman.co/workspace/1b5d7508-dbfc-423a-91f3-8f14b2a483d5/collection/28181483-f34f0419-a528-498c-9243-820ad592ccab
