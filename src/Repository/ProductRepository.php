<?php

namespace App\Repository;

use App\Model\Product;
use PDO;

class ProductRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function getHomeListing(): array
    {
        $sql = <<<SQL
        SELECT p.id, p.name, p.brand, p.category, p.in_stock,
               pp.amount AS price,
               pg.image_url
        FROM products p
        LEFT JOIN product_prices pp ON pp.product_id = p.id
        LEFT JOIN (
            SELECT product_id, MIN(id) AS min_id
            FROM product_gallery
            GROUP BY product_id
        ) pg_min ON pg_min.product_id = p.id
        LEFT JOIN product_gallery pg ON pg.id = pg_min.min_id
    SQL;

        $stmt = $this->pdo->query($sql);
        return array_map(function ($row) {
            return new Product(
                id: $row['id'],
                name: $row['name'],
                brand: $row['brand'],
                category: $row['category'],
                inStock: (bool) $row['in_stock'],
                price: (float) $row['price'],
                gallery: [$row['image_url']]
            );
        }, $stmt->fetchAll());
    }

}
