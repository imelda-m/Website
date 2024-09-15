<?php
require_once 'Product.php';

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price, 'DVD');
        $this->size = $size;
    }

    public function getDetails() {
        return [
            'size' => $this->size . ' MB'
        ];
    }
   

    public static function createFromForm($formData) {
        return new self($formData['skuInput'], $formData['nameInput'], $formData['price'], $formData['size']);
    }
}

?>
