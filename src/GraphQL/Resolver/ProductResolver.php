<?php

namespace App\GraphQL\Resolver;

use App\Factory\ProductFactory;
use App\Model\Product;

class ProductResolver
{
    public function __construct(private ProductFactory $productFactory)
    {
    }

    public function getProduct(string $id): Product
    {
        return $this->productFactory->load(id: $id);
    }

    public function getAllProducts(): array
    {
        return $this->productFactory->loadMany();
    }
}
