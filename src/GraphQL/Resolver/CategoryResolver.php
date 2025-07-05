<?php

namespace App\GraphQL\Resolver;

use App\Model\Category;
use App\Repository\CategoryRepository;

class CategoryResolver
{
    public function __construct()
    {
    }

    public function getCategories(): array
    {
        return Category::getAll();
    }
}
