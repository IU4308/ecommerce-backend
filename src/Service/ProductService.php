<?php

namespace App\Service;

class ProductService extends Service
{
    protected function getTable(): string
    {
        return 'products';
    }

    public function getAll($category = null): array
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.brand',
                'p.category',
                'p.in_stock',
                'pp.amount',
                'pp.currency_label',
                'pp.currency_symbol',
                'pg.image_url'
            )
            ->from('products', 'p')
            ->leftJoin('p', 'product_prices', 'pp', 'pp.product_id = p.id')
            ->leftJoin(
                'p',
                '(SELECT product_id, MIN(id) AS min_id FROM product_gallery GROUP BY product_id)',
                'pg_min',
                'pg_min.product_id = p.id'
            )
            ->leftJoin('pg_min', 'product_gallery', 'pg', 'pg.id = pg_min.min_id');

        if ($category !== null && $category !== 'all') {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $category);
        }

        return $qb->executeQuery()->fetchAllAssociative();
    }

}
