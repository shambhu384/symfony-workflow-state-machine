<?php

namespace App;


class Product {

    public $name;

    public $price;

    public function __construct(string $name, string $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}
