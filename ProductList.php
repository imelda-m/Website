<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styleP.css">
    <title>Product List</title>

    <?php
        // Dynamically add a stylesheet
        echo '<link rel="stylesheet" type="text/css" href="./styles/styleP.css">';
    ?>
</head>
<body>
    <header>
        <h1>Product List</h1>
        <div id="button_container">
            <button id="add_product_btn">ADD</button>
            <button id="delete-product-bin">MASS Delete</button>
        </div>
        </header>
        <section id="product-list">
          <form method="POST" action="form-submission.php">
         <!-- Products -->
          <div class="products">

          <?php
           echo '<link rel="stylesheet" type="text/css" href="./styles/styleP.css">';
             require('database.php');
             $db = new Database();
             $db->displayPrFromDb();

            echo '<link rel="stylesheet" type="text/css" href="./styles/styleP.css">';
          ?>
          </div>
           </form>
    </section>
          
            
    <footer>
        ScandiWeb Test assignment
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./scripts/AddDeleteBtn.js"></script>
</body>
</html>