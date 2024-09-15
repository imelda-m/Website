<?php
// Include necessary files for database connection, product creation, and product management
require('./productHandle/database.php');
require('./productHandle/ProductFactory.php');
require('./productHandle/ProductManager.php');

$db = new Database();
// Create a new instance of the ProductManager class with the database connection
$productManager = new ProductManager($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nameInput'])) {
        // Create a product object using the ProductFactory with the POST data
        $product = ProductFactory::createProduct($_POST);
        // Add the created product to the database using ProductManager
        $productManager->addProductToDb($product);
    } else {
        $productManager->deleteCheckedProducts();
    }
    
    header("Location: ProductList.php");
    exit();
}
?>
