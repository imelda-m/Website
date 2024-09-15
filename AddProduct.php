<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add</title>
    <link rel="stylesheet" href="./styles/styleA.css">
</head>
<body>
    <header>
        <h1>Add Product</h1>
        <div id="btn-container">
        <button type="submit">Save</button>
        <button type="button" onclick="window.location.href='index.html'">Cancel</button>
    </div>
    </header>
    <main>
        <form id="product_form" method="POST" action="Form-submission.php">
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="skuInput" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="nameInput" required>
            </div>
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="productType">Type Switcher</label>
                <select id="productType" name="productType" required>
                    <option value="">TypeSwitcher</option>
                    <option value="DVD">DVD</option>
                    <option value="Book">Book</option>
                    <option value="Furniture">Furniture</option>
                </select>
            </div>
            <fieldset class="form-group type-specific" id="dvd-fields">
                <label for="size">Size (MB)</label>
                <input type="number" id="size" name="size">
            </fieldset>
            <fieldset class="form-group type-specific" id="book-fields">
                <label for="weight">Weight (KG)</label>
                <input type="number" id="weight" name="weight">
            </fieldset>
            <fieldset class="form-group type-specific" id="furniture-fields">
                <label for="height">Height (CM)</label>
                <input type="number" id="height" name="height">
                <label for="width">Width (CM)</label>
                <input type="number" id="width" name="width">
                <label for="length">Length (CM)</label>
                <input type="number" id="length" name="length">
            </fieldset>

            <span id="input-warning"></span>

           
            <div id="sku-taken-values-container">
                <?php
                    require('./productHandle/database.php');
                    require('./productHandle/ProductManager.php');
                    $database = new Database();
                    $manager = new ProductManager($database);
                ?>
            </div>
        </form>
    </main>
    
    
    <footer>
        ScandiWeb Test assignment
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./scripts/saveCancel.js"></script>
    <script src="./scripts/HideFields.js"></script>
</body>
</html>
