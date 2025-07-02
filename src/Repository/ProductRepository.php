<?php

namespace App\Repository;

use App\Model\Product;
use Doctrine\DBAL\Connection;

class ProductRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function getHomeListing(): array
    {
        $qb = $this->db->createQueryBuilder();

        $qb->select(
            'p.id',
            'p.name',
            'p.brand',
            'p.category',
            'p.in_stock',
            'pp.amount AS price',
            'pg.image_url'
        )
            ->from('products', 'p')
            ->leftJoin('p', 'product_prices', 'pp', 'pp.product_id = p.id')
            ->leftJoin('p', '(SELECT product_id, MIN(id) AS min_id FROM product_gallery GROUP BY product_id)', 'pg_min', 'pg_min.product_id = p.id')
            ->leftJoin('p', 'product_gallery', 'pg', 'pg.id = pg_min.min_id');

        $rows = $qb->executeQuery()->fetchAllAssociative();

        return array_map(fn($row) => new Product(
            id: $row['id'],
            name: $row['name'],
            brand: $row['brand'],
            category: $row['category'],
            inStock: (bool) $row['in_stock'],
            price: (float) $row['price'],
            gallery: [$row['image_url']]
        ), $rows);
    }

}
