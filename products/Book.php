<?php
require_once 'Product.php';

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price, 'Book');
        $this->weight = $weight;
    }

    public function getDetails() {
        return [
            'weight' => $this->weight . ' Kg'
        ];
    }

    public static function createFromForm($formData) {
        return new self($formData['skuInput'], $formData['nameInput'], $formData['price'], $formData['weight']);
    }
}

?>
