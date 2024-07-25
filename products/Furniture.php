<?php

   require_once 'Product.php';

   class Furniture extends Product{
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

      public function &getHeight($args){
        return $args['height'];
      }
      public function &getWidtht($args){
        return $args['width'];
      }
      public function &getLength($args){
        return $args['length'];
      }

      public function displayP($row){
           $price = number_format((float)$row['price'],2,'-', '');
           echo <<< PRODUCT
           <div class='product'>
               <input class='delete-checkbox' type='checkbox' name='deleteCheckbox[]' value={$row['sku']}>
               <span>{$row['sku']}</span>
               <span>{$row['name']}</span>
               <span>{$price} $</span>
               <span>{$row['height']}x{$row['width']}x{$row['length']} CM</span> 
           </div>
PRODUCT;
      }
   }

?>