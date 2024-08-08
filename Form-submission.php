<?php
require('database.php');
require('ProductFactory.php');
require('ProductManager.php');

$db = new Database();
$productManager = new ProductManager($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nameInput'])) {
        $product = ProductFactory::createProduct($_POST);
        $productManager->addProductToDb($product);
    } else {
        $productManager->deleteCheckedProducts();
    }
    
    header("Location: ProductList.php");
    exit();
}
?>
