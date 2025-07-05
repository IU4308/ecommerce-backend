<?php

namespace App\Factory;

use App\Model\Category;
use App\Service\CategoryService;

class CategoryFactory extends Factory
{
    protected function modelClass(): string
    {
        return Category::class;
    }

    protected function serviceClass(): string
    {
        return CategoryService::class;
    }

}