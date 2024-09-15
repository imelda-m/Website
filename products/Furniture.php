<?php
require_once 'Product.php';

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width , $length) {
        parent::__construct($sku, $name, $price, 'Furniture');
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;

        
    }

    public function getDetails() {
       
       
        
        return [
           'Dimensions' => $this->height . 'x' . $this->width . 'x' . $this->length
        //    'height' => $this->height,
        //    'width' => $this->width,
        //    'length' => $this->length,
        ];
    
    }
    

    public function renderDetails() {
        return '<p>Dimensions: ' . $this->height . 'x' . $this->width . 'x' . $this->length . '</p>';
    }

    public static function createFromForm($formData) {
        
        return new self(
            $formData['skuInput'], 
            $formData['nameInput'], 
            $formData['price'], 
            $formData['height'], 
            $formData['width'], 
            $formData['length']
        );
    }
}

?>
