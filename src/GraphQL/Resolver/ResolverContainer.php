<?php

namespace App\GraphQL\Resolver;

use App\Factory\AttributeFactory;
use App\Factory\OrderFactory;
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

    public function attribute(): AttributeResolver
    {
        return new AttributeResolver(
            new AttributeFactory($this->connection)
        );
    }

    public function order(): OrderResolver
    {
        return new OrderResolver(
            new OrderFactory($this->connection)
        );
    }
}
