<?php

namespace App\GraphQL\Resolver;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Connection;

class ResolverContainer
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function category(): CategoryResolver
    {
        return new CategoryResolver(new CategoryRepository($this->connection));
    }

    public function product(): ProductResolver
    {
        return new ProductResolver(new ProductRepository($this->connection));
    }

}
