<?php

namespace App\GraphQL\Resolver;

use App\Repository\ProductRepository;
use App\Model\Product;

class ProductResolver
{
    public function __construct()
    {
    }

    public function getProduct(string $id): Product
    {
        return Product::get($id);
    }

    public function getAllProducts(): array
    {
        return Product::getAll();
    }
}
