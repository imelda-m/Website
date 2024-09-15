<?php

class ProductFactory {
    public static function createProduct($formData) {
        $type = $formData['productType'];
        require_once './products/' . $type . '.php';

        $className = ucfirst($type);
         // Check if the class exists
        if (class_exists($className)) {
            // Call the static createFromForm method of the class to create and return an instance
            return $className::createFromForm($formData);
        } else {
            throw new Exception("Unknown product type: $type");
        }
    }
}


?>
