<?php

namespace App\GraphQL\Resolver;

use App\Factory\CategoryFactory;

class CategoryResolver extends Resolver
{
    public function __construct(CategoryFactory $factory)
    {
        parent::__construct($factory);
    }
}
