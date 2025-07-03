<?php

namespace App\Model\Product;

class TechProduct extends BaseProduct
{
    public function getType(): string
    {
        return 'tech';
    }
}