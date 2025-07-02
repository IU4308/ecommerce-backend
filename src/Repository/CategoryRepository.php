<?php

namespace App\Repository;

use App\Model\Category;
use Doctrine\DBAL\Connection;

class CategoryRepository
{
    public function __construct(private Connection $db)
    {
    }

    /** @return Category[] */
    public function getAll(): array
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('name')
            ->from('categories');
        $rows = $qb->executeQuery()->fetchAllAssociative();
        // $stmt = $this->connection->query("SELECT name FROM categories");
        return array_map(fn($row) => new Category($row['name']), $rows);
    }
}
