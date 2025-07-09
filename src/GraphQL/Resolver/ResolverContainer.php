<?php

namespace App\GraphQL\Resolver;

use Doctrine\DBAL\Connection;
use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Factory\AttributeFactory;
use App\Factory\OrderFactory;
use App\Factory\PriceFactory;
use App\Factory\GalleryFactory;
use App\Factory\OrderItemFactory;
use App\Factory\OrderAttributeFactory;

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
            new ProductFactory(
                $this->connection,
                new PriceFactory($this->connection),
                new GalleryFactory($this->connection),
                new AttributeFactory($this->connection)
            )
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
            new OrderFactory(
                $this->connection,
                new OrderItemFactory($this->connection),
                new OrderAttributeFactory($this->connection)
            )
        );
    }
}
