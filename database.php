<?php

class Database {
    private $databaseHandle;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        // Load database configuration from JSON file
        $config = json_decode(file_get_contents('file.json'), true);

        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Error decoding JSON: " . json_last_error_msg());
        }

        // Create connection using PDO
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
            $this->databaseHandle = new PDO($dsn, $config['user'], $config['password']);
            // Set the PDO error mode to exception
            $this->databaseHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "Successfully connected to the database";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function checkTakenSKU($sku) {
        $stmt = $this->databaseHandle->prepare('SELECT * FROM products WHERE sku = ?');
        $stmt->execute([$sku]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return !empty($result);
    }

    public function outputSKUTakenValues() {
        $stmt = $this->databaseHandle->prepare('SELECT sku FROM products');
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $value) {
            echo $value['sku'] . " ";
        }
    }

    public function addProductToDb($sku, $name, $price, $productType, $size, $weight, $height, $width, $length) {
        $args = array();

        foreach ($_POST as $key => $value) {
            if (!empty($key)) {
                $args[$key] = $value;
            }
        }

        if ($this->checkTakenSKU($args['skuInput'])) {
            header("Location: AddProduct.html");
            return;
        }

        $sku = $args['skuInput'];
        $name = $args['nameInput'];
        $price = $args['price'];
        $type = $args['productType'];
        $size = (!empty($args['size']) && $type == 'DVD') ? $args['size'] : null;
        $weight = (!empty($args['weight']) && $type == 'Book') ? $args['weight'] : null;
        $height = (!empty($args['height']) && $type == 'Furniture') ? $args['height'] : null;
        $width = (!empty($args['width']) && $type == 'Furniture') ? $args['width'] : null;
        $length = (!empty($args['length']) && $type == 'Furniture') ? $args['length'] : null;

        $query = 'INSERT INTO products (sku, name, price, type, size, weight, height, width, length)
                  VALUES (:sku, :name, :price, :type, :size, :weight, :height, :width, :length)';
        $stmt = $this->databaseHandle->prepare($query);

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

    public function displayPrFromDb() {
        $stmt = $this->databaseHandle->prepare('SELECT * FROM products');
        try {
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $productType = $row['type'];
                require_once('./products/' . $productType . '.php');
                switch ($productType) {
                    case 'DVD':
                        $product = new DVD($row['sku'], $row['name'], $row['price'], $row['size']);
                        break;
                    case 'Book':
                        $product = new Book($row['sku'], $row['name'], $row['price'], $row['weight']);
                        break;
                    case 'Furniture':
                        $product = new Furniture($row['sku'], $row['name'], $row['price'], $row['height'], $row['width'], $row['length']);
                        break;
                    default:
                        throw new Exception("Unknown product type: $productType");
                }

                echo '<div class="product-item" id="product-list">';
                echo '<input type="checkbox" class="delete-checkbox" name="delete-checkbox[]" value="' . $row['sku'] . '">';
                echo '<div class="product-details">';
                echo '<p>SKU: ' . $row['sku'] . '</p>';
                echo '<p>Name: ' . $row['name'] . '</p>';
                echo '<p>Price: $' . $row['price'] . '</p>';
                switch ($productType) {
                    case 'DVD':
                        echo '<p>Size: ' . $row['size'] . ' MB</p>';
                        break;
                    case 'Book':
                        echo '<p>Weight: ' . $row['weight'] . ' Kg</p>';
                        break;
                    case 'Furniture':
                        echo '<p>Dimensions: ' . $row['height'] . 'x' . $row['width'] . 'x' . $row['length'] . '</p>';
                        break;
                }
                echo '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo($e->getMessage());
        }
    }

    public function deleteCheckedProductsFromDatabase() {
        // Check, if there are any checked checkboxes.
        if (isset($_POST['delete-checkbox'])) {
            // Get all checked checkboxes' values (that are SKU values).
            $products = $_POST['delete-checkbox'];

            // Prepare SQL query for deletion.
            $stmt = $this->databaseHandle->prepare('DELETE FROM products WHERE sku = ?');

            // For each SKU acquired, execute a SQL query.
            try {
                foreach ($products as $productSKU) {
                    $stmt->execute([$productSKU]);
                }
            } catch (PDOException $e) {
                echo($e->getMessage());
            }

            // Return to the home page.
            header("Location: ProductList.php");
        }
    }
}

?>
