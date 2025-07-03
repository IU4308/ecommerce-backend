<?php

namespace App\GraphQL\Resolver;
use App\Model\Product;
use App\Model\Product\BaseProduct;
use App\Model\Product\DetailedProduct;
use App\Model\Product\HomeProduct;

use App\Repository\ProductRepository;

class ProductResolver
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function getAllProducts(): array
    {
        return $this->repository->getHomeListing();
    }
    public function getProduct(string $id): BaseProduct
    {
        return $this->repository->getProductDetails($id);
    }
}
