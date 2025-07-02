<?php

namespace App\Model;

class Product
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $brand,
        public readonly string $category,
        public readonly bool $inStock,
        public readonly float $price,
        public readonly array $gallery = [],
        public readonly array $attributes = [],
        public readonly string $description = ''
    ) {
    }
}