<?php

namespace App\GraphQL\Resolver;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class ResolverContainer
{
    public function __construct(
        private \PDO $pdo
    ) {
    }

    public function category(): CategoryResolver
    {
        return new CategoryResolver(new CategoryRepository($this->pdo));
    }

    public function product(): ProductResolver
    {
        return new ProductResolver(new ProductRepository($this->pdo));
    }

    // Add more as needed (attribute(), order(), etc.)
}
