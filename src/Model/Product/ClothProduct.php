<?php

namespace App\Model\Product;

class ClothProduct extends BaseProduct
{
    public function getType(): string
    {
        return 'cloth';
    }
}
