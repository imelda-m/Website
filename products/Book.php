<?php 
     require_once 'Product.php';

     class Book extends Product{
        private $weight;

        public function __construct($sku, $name, $price, $weight) {
            parent::__construct($sku, $name, $price);
            $this->weight = $weight;
        }
    
        public function &getWeight($args){
             return $args['weight'];
        }


        public function displayP($row){
            echo <<< PRODUCT
                <div class='product'>
                    <input class='delete-checkbox' type='checkbox' name='deleteCheckbox[]' value={$row['sku']}>
                    <span>{$row['sku']}</span>
                    <span>{$row['name']}</span>
                    <span>{$row['weight']} KG</span> 
                </div>
            PRODUCT;  
        }
     }

?>