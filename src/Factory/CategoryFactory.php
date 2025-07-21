<?php

namespace App\Factory;

use App\Model\Category;
use App\Service\CategoryService;

class CategoryFactory extends Factory
{
    protected function resolveModelClass(): string
    {
        return Category::class;
    }

    protected function resolveServiceClass(): string
    {
        return CategoryService::class;
    }

}