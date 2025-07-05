<?php

namespace App\GraphQL\Resolver;

use App\Factory\CategoryFactory;

class CategoryResolver
{
    public function __construct(private CategoryFactory $categoryFactory)
    {
    }

    public function getCategories(): array
    {
        return $this->categoryFactory->loadMany();
    }
}
