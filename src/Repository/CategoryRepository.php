<?php

namespace App\Repository;

use App\Factory\CategoryFactory;
use App\Model\Category;
use Doctrine\DBAL\Connection;

class CategoryRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function getAll(): array
    {
        return Category::getAll();
    }
}
