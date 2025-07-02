<?php

namespace App\Model\Product;
use App\Repository\ProductRepository;

class HomeProduct extends BaseProduct
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function get(mixed $context = null): array
    {
        return $this->repository->getHomeListing();
    }
}
