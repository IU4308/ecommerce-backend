<?php

namespace App\GraphQL\Resolver;
use App\Model\Product\HomeProduct;

use App\Repository\ProductRepository;

class ProductResolver
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function getForHome(): array
    {
        return (new HomeProduct($this->repository))->get();
    }
}
