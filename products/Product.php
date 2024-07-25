<?php

 abstract class Product{

    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function &getSKU($args){
        return $args['sku'];
    }

    public function &getName($args){
        return $args['name'];
    }

    public function &getPrice($args){
        return $args['price'];
    }
    public function &getTpeSwitcher($args){
        return $args['productType'];
    }


    protected abstract function displayP($row);
    //abstract public function save();
 }


?>