# Simple PHP RESTful API

I've created a simple RESTful API built using plain PHP. It performs basic CRUD operations
on a "products" resource stored in a MySQL database.

## How It Works

### Overview

- `config.php`: This file sets up the connection to the MySQL database. It contains details like the database host, name, username, and password.
- `api.php`: This is the main API file that handles different HTTP requests (GET, POST, PUT, DELETE) to manage the products.

### API Endpoints

| HTTP Method | Endpoint       | Description                        |
| ----------- | -------------- | ---------------------------------- |
| GET         | /products      | Retrieves all products             |
| GET         | /products/{id} | Retrieves a specific product by ID |
| POST        | /products      | Adds a new product                 |
| PUT         | /products/{id} | Updates a product by ID            |
| DELETE      | /products/{id} | Deletes a product by ID            |

## How to Set Up

1. Import the SQL structure:

   - Create a MySQL database named `products_db`.
   - Import the table structure using this SQL script:

     ```sql
     CREATE DATABASE products_db;
     USE products_db;

     CREATE TABLE products (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         description TEXT,
         price DECIMAL(10, 2) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     );
     ```

2. Place `config.php` and `api.php` in your server’s root directory (e.g., `htdocs` for XAMPP).

3. Make sure your PHP server (Apache) is running.

## Testing with Postman

### Step 1: Open Postman

Download and open Postman if you haven’t already.

### Step 2: Test Each Endpoint

#### **1. Get All Products**

- Method: `GET`
- URL: `http://localhost/api.php/products`
- Click "Send" to retrieve a list of all products.

#### **2. Get a Specific Product by ID**

- Method: `GET`
- URL: `http://localhost/api.php/products/1` (Replace `1` with the actual ID you want to fetch)
- Click "Send" to retrieve the product details.

#### **3. Add a New Product**

- Method: `POST`
- URL: `http://localhost/api.php/products`
- Select "Body" > "raw" > "JSON" and enter:
  ```json
  {
    "name": "Sample Product",
    "description": "This is a great product",
    "price": 49.99
  }
  ```

#### **4. Update an Existing Product**

- Method: `PUT`
- URL: `http://localhost/api.php/products/1` (Replace `1` with the actual ID you want to fetch)
- Click "Send" to delete the product.
