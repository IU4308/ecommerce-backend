<?php

namespace App\Repository;

use App\Factory\CategoryFactory;
use Doctrine\DBAL\Connection;

class CategoryRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function getAll(): array
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('name')
            ->from('categories');
        $rows = $qb->executeQuery()->fetchAllAssociative();
        return array_map(fn($row) => CategoryFactory::make($row['name']), $rows);
    }
}
