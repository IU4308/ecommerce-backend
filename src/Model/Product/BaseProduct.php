<?php

namespace App\Model\Product;

use App\Model\ProductPrice;

abstract class BaseProduct
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $brand,
        public readonly string $category,
        public readonly bool $inStock,
        public readonly ProductPrice $price,
        public readonly array $gallery = [],
        public readonly array $attributes = [],
        public readonly string $description = ''
    ) {
    }

    abstract public function getType(): string;
}
