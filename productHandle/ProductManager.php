<?php

require_once './productHandle/database.php';
require_once './productHandle/ProductFactory.php';

class ProductManager {
    private $db;

    // Constructor to initialize the database connection
    public function __construct(Database $database) {
        $this->db = $database->getDatabaseHandle();
    }
// Check if the given SKU is already taken
    public function checkTakenSKU($sku) {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE sku = ?');
        $stmt->execute([$sku]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return !empty($result);
    }

    public function outputSKUTakenValues() {
        $stmt = $this->db->prepare('SELECT sku FROM products');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);
        foreach ($result as $value) {
            echo $value['sku'] . " ";
        }
    }
       // Add a new product to the database
    public function addProductToDb($product) {
        if ($this->checkTakenSKU($product->getSku())) {
            header("Location: AddProduct.html");
            return;
        }
    // Extract product details
        $sku = $product->getSku();
        $name = $product->getName();
        $price = $product->getPrice();
        $type = $product->getType();

        $details = $product->getDetails();
        $size = $details['size'] ?? null;
        $weight = $details['weight'] ?? null;
        $height = $details['height'] ?? null;
        $width = $details['width'] ?? null;
        $length = $details['length'] ?? null;
       

  // Prepare and execute the SQL query to insert the product
        $query = 'INSERT INTO products (sku, name, price, type, size, weight, height, width, length)
                  VALUES (:sku, :name, :price, :type, :size, :weight, :height, :width, :length)';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':size', $size, PDO::PARAM_INT);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);
        $stmt->bindParam(':width', $width, PDO::PARAM_INT);
        $stmt->bindParam(':length', $length, PDO::PARAM_INT);
       
        

        $stmt->execute();
        header("Location: ProductList.php");
    }
  // Display all products with their details
    public function displayProducts() {
        // Map product types to their respective constructor arguments
        $constructorArgsMapping = [
            'Book' => ['sku', 'name', 'price', 'weight'],
            'DVD' => ['sku', 'name', 'price', 'size'],
            'Furniture' => ['sku', 'name', 'price', 'height', 'width', 'length'],
        ];
          // Prepare and execute the SQL query to fetch all products
        $stmt = $this->db->prepare('SELECT * FROM products');
        try {
            $stmt->execute();
            $result = $stmt->fetchAll();
        
            foreach ($result as $row) {
                $productType = $row['type'];
                require_once './products/' . $productType . '.php';
        
                $className = ucfirst($productType);
                if (class_exists($className)) {
                    $reflection = new ReflectionClass($className);
                    $constructorArgs = $constructorArgsMapping[$productType]; // Use $productType
        
                    $params = [];
                    foreach ($constructorArgs as $arg) {
                        $params[] = $row[$arg] ?? null; 
                    }
        
                    $product = $reflection->newInstanceArgs($params);
        
                    echo '<div class="product-item" id="product-list">';
                    echo '<input type="checkbox" class="delete-checkbox" name="delete-checkbox[]" value="' . $row['sku'] . '">';
                    echo '<div class="product-details">';
                    echo '<p>SKU: ' . $row['sku'] . '</p>';
                    echo '<p>Name: ' . $row['name'] . '</p>';
                    echo '<p>Price: $' . $row['price'] . '</p>';
                    $details = $product->getDetails();
                    foreach ($details as $key => $value) {
                        echo '<p>' . ucfirst($key) . ': ' . $value . '</p>';
                    }
                    echo '</div>';
                    echo '</div>';
                } else {
                    throw new Exception("Unknown product type: $productType");
                }
            }
         } catch (PDOException $e) {
            echo($e->getMessage());
        }
    }
        
    // Delete selected products from the database

    public function deleteCheckedProducts() {
        if (isset($_POST['delete-checkbox'])) {
            $products = $_POST['delete-checkbox'];
            $stmt = $this->db->prepare('DELETE FROM products WHERE sku = ?');
            try {
                foreach ($products as $productSKU) {
                    $stmt->execute([$productSKU]);
                }
            } catch (PDOException $e) {
                echo($e->getMessage());
            } finally {
                echo "cannot delete";
            }
            header("Location: ProductList.php");
        }
    }
}

?>
