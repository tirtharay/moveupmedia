<?php
/**
 * Simple RESTful API for managing products
 * This script performs CRUD operations on a MySQL database using raw PHP and PDO.
 *
 * Endpoints:
 * - GET /products: Retrieve a list of all products
 * - GET /products/{id}: Retrieve a specific product by ID
 * - POST /products: Add a new product
 * - PUT /products/{id}: Update an existing product by ID
 * - DELETE /products/{id}: Delete a product by ID
 */

header('Content-Type: application/json');
require 'config.php';

// Get the HTTP method and the URI path
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['PATH_INFO'], '/'));

// Main route handling
if (isset($uri[0]) && $uri[0] === 'products') {
    switch ($method) {
        case 'GET':
            if (isset($uri[1])) {
                getProduct($uri[1]);
            } else {
                getProducts();
            }
            break;
        case 'POST':
            addProduct();
            break;
        case 'PUT':
            if (isset($uri[1])) {
                updateProduct($uri[1]);
            }
            break;
        case 'DELETE':
            if (isset($uri[1])) {
                deleteProduct($uri[1]);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['message' => 'Method Not Allowed']);
            break;
    }
}

/**
 * Retrieve all products from the database.
 */
function getProducts() {
    global $pdo;

    try {
        $stmt = $pdo->query('SELECT * FROM products');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Internal Server Error', 'error' => $e->getMessage()]);
    }
}

/**
 * Retrieve a specific product by ID from the database.
 *
 * @param int $id The ID of the product to retrieve.
 */
function getProduct($id) {
    global $pdo;

    try {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Internal Server Error', 'error' => $e->getMessage()]);
    }
}

/**
 * Add a new product to the database.
 * Expects a JSON payload with the following fields: name, description, and price.
 */
function addProduct() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['name'], $data['description'], $data['price'])) {
        try {
            $stmt = $pdo->prepare('INSERT INTO products (name, description, price) VALUES (?, ?, ?)');
            $stmt->execute([$data['name'], $data['description'], $data['price']]);
            http_response_code(201);
            echo json_encode(['message' => 'Product created']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Internal Server Error', 'error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
    }
}

/**
 * Update an existing product by ID in the database.
 * Expects a JSON payload with the following fields: name, description, and price.
 *
 * @param int $id The ID of the product to update.
 */
function updateProduct($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['name'], $data['description'], $data['price'])) {
        try {
            $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?');
            $stmt->execute([$data['name'], $data['description'], $data['price'], $id]);
            echo json_encode(['message' => 'Product updated']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Internal Server Error', 'error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
    }
}

/**
 * Delete a product by ID from the database.
 *
 * @param int $id The ID of the product to delete.
 */
function deleteProduct($id) {
    global $pdo;

    try {
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Product deleted']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Internal Server Error', 'error' => $e->getMessage()]);
    }
}
?>
