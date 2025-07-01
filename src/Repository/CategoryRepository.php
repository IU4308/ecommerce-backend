<?php

namespace App\Repository;

use PDO;
use App\Model\Category;

class CategoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    /** @return Category[] */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT name FROM categories");
        return array_map(fn($row) => new Category($row['name']), $stmt->fetchAll());
    }
}
