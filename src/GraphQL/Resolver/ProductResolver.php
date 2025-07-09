<?php

namespace App\GraphQL\Resolver;

use App\Factory\ProductFactory;

class ProductResolver extends Resolver
{
    public function __construct(ProductFactory $factory)
    {
        parent::__construct($factory);
    }
}
