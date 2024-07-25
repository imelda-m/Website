<?php
    // Including DatabaseActivity class.
    require('database.php');

    // Initialize DatabaseActivity class for further operations.
    $db = new Database();

    // Checks once form is submitted (necessary to call needed function based on the input of the form).
    if(!isset($_POST['submit']) && isset($_POST['nameInput'])) // If form contains input for the name - form adds product to database.
        $db->addProductToDb( $_POST['skuInput'],
        $_POST['nameInput'],
        $_POST['price'],
        $_POST['productType'],
        $_POST['size'] ?? null,
        $_POST['weight'] ?? null,
        $_POST['height'] ?? null,
        $_POST['width'] ?? null,
        $_POST['length'] ?? null);
    else if(!isset($_POST['submit']) && !isset($_POST['nameInput'])) // Otherwise - form deletes checked products from database.
        $db->deleteCheckedProductsFromDatabase(); 
        
       
?>

<