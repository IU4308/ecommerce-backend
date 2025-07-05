<?php

namespace App\GraphQL\Resolver;

use App\Repository\AttributeRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductAttributeRepository;
use App\Repository\ProductGalleryRepository;
use App\Repository\ProductPriceRepository;
use Doctrine\DBAL\Connection;

class ResolverContainer
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function category(): CategoryResolver
    {
        return new CategoryResolver();
    }

    public function product(): ProductResolver
    {
        return new ProductResolver();
    }
}
