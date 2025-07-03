<?php
namespace App\Factory;

use App\Model\Category\BaseCategory;
use App\Model\Category\ClothesCategory;
use App\Model\Category\TechCategory;
class CategoryFactory
{
    public static function make(string $name): BaseCategory
    {
        return match ($name) {
            'tech' => new TechCategory($name),
            'clothes' => new ClothesCategory($name),
        };
    }
}
