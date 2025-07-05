<?php

namespace App\GraphQL\Resolver;

use App\Factory\ProductFactory;
use Doctrine\DBAL\Connection;
use App\Factory\CategoryFactory;

class ResolverContainer
{
    public function __construct(private Connection $connection)
    {
    }

    public function category(): CategoryResolver
    {
        return new CategoryResolver(
            new CategoryFactory($this->connection)
        );
    }

    public function product(): ProductResolver
    {
        return new ProductResolver(
            new ProductFactory($this->connection)
        );
    }
}
