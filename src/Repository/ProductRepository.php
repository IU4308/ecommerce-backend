<?php

namespace App\Repository;

use App\Model\Product\BaseProduct;
use App\Model\ProductPrice;
use App\Model\AttributeItem;
use App\Model\SwatchAttribute;
use App\Model\TextAttribute;
use Doctrine\DBAL\Connection;

class ProductRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function getHomeListing(): array
    {
        $rows = $this->fetchHomeListingRows();
        return array_map([$this, 'mapRowToProduct'], $rows);
    }

    public function getProductDetails(string $productId): BaseProduct
    {
        $rows = $this->fetchProductDetails($productId);
        $productData = $rows[0];

        $attributes = $this->buildAttributeObjects($rows);
        $gallery = $this->fetchProductGallery($productId);

        return $this->buildProductFromRow($productData, $gallery, $attributes);
    }

    // ----------------- Internals -----------------

    private function buildAttributeObjects(array $rows): array
    {
        $grouped = [];

        foreach ($rows as $row) {
            if (!$row['attribute_name']) {
                continue;
            }

            $name = $row['attribute_name'];
            $type = $row['attribute_type'];

            if (!isset($grouped[$name])) {
                $grouped[$name] = [
                    'type' => $type,
                    'items' => [],
                ];
            }

            $grouped[$name]['items'][] = new AttributeItem(
                itemId: $row['item_id'],
                value: $row['value'],
                displayValue: $row['display_value']
            );
        }

        return array_map(function ($name, $data) {
            return match ($data['type']) {
                'swatch' => new SwatchAttribute($name, $data['type'], $data['items']),
                'text' => new TextAttribute($name, $data['type'], $data['items']),
            };
        }, array_keys($grouped), $grouped);
    }

    private function buildProductFromRow(array $row, array $gallery, array $attributes = []): BaseProduct
    {
        $price = new ProductPrice(
            productId: $row['id'],
            amount: (float) $row['amount'],
            currencyLabel: $row['currency_label'],
            currencySymbol: $row['currency_symbol']
        );

        return $this->createProductInstance($row['category'], [
            $row['id'],
            $row['name'],
            $row['brand'],
            $row['category'],
            (bool) $row['in_stock'],
            $price,
            $gallery,
            $attributes,
            $row['description'] ?? '',
        ]);
    }

    private function mapRowToProduct(array $row): BaseProduct
    {
        $gallery = [$row['image_url']];

        return $this->buildProductFromRow($row, $gallery);
    }

    private function createProductInstance(string $category, array $args): BaseProduct
    {
        $map = [
            'tech' => \App\Model\Product\TechProduct::class,
            'clothes' => \App\Model\Product\ClothProduct::class,
        ];

        $class = $map[$category];
        return new $class(...$args);
    }

    private function fetchHomeListingRows(): array
    {
        return $this->db->createQueryBuilder()
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
            ->leftJoin('p', '(SELECT product_id, MIN(id) AS min_id FROM product_gallery GROUP BY product_id)', 'pg_min', 'pg_min.product_id = p.id')
            ->leftJoin('p', 'product_gallery', 'pg', 'pg.id = pg_min.min_id')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function fetchProductDetails(string $productId): array
    {
        return $this->db->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.brand',
                'p.category',
                'p.in_stock',
                'p.description',
                'pp.amount',
                'pp.currency_label',
                'pp.currency_symbol',
                'a.attribute_name',
                'a.attribute_type',
                'i.item_id',
                'i.display_value',
                'i.value'
            )
            ->from('products', 'p')
            ->leftJoin('p', 'product_attributes', 'a', 'p.id = a.product_id')
            ->leftJoin('p', 'attribute_items', 'i', 'p.id = i.product_id AND a.attribute_name = i.attribute_name')
            ->innerJoin('p', 'product_prices', 'pp', 'p.id = pp.product_id')
            ->where('p.id = :productId')
            ->setParameter('productId', $productId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function fetchProductGallery(string $productId): array
    {
        return $this->db->createQueryBuilder()
            ->select('image_url')
            ->from('product_gallery')
            ->where('product_id = :id')
            ->setParameter('id', $productId)
            ->executeQuery()
            ->fetchFirstColumn();
    }
}
