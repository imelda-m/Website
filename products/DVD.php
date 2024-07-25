<?php
    // Including abstract Product class.
    require_once 'Product.php';

    // DVD Product class based on abstract Product class.
    class DVD extends Product {

        private $size;

        public function __construct($sku, $name, $price, $size) {
            parent::__construct($sku, $name, $price);
            $this->size = $size;
        }
    
        // Function to get size of the DVD.
        protected function &getSize($args) {
            return $args['size'];
        }

    
        // Function for DVD to be displayed on Product List.
        public function displayP($row)
        {
            $price = number_format((float)$row['price'], 2, '.', '');
            echo <<< PRODUCT
                <div class='product'>
                    <input class='delete-checkbox' type='checkbox' name='deleteCheckbox[]' value={$row['sku']}>
                    <span>{$row['sku']}</span>
                    <span>{$row['name']}</span>
                    <span>{$price} $</span>
                    <span>{$row['size']} MB</span>
                </div>
PRODUCT;
        }
    }
?>