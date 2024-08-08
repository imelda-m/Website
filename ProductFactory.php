<?php

class ProductFactory {
    public static function createProduct($formData) {
        $type = $formData['productType'];
        require_once './products/' . $type . '.php';

        $className = ucfirst($type);
        if (class_exists($className)) {
            return $className::createFromForm($formData);
        } else {
            throw new Exception("Unknown product type: $type");
        }
    }
}

?>
