<?php

namespace App\Model;

class Product extends Model
{
    protected static string $table = 'products';

    public string $id;
    public string $name;
    public string $brand;
    public string $category;
    public bool $in_stock;
    public string $description = '';

    public ?ProductPrice $price = null;
    public array $gallery = [];
    public array $attributes = [];

    public static function get(string $id): static
    {
        $product = parent::get($id);
        $product->price = ProductPrice::getByProductId($id);
        $product->gallery = ProductGallery::findBy(['product_id' => $id]);
        $product->attributes = Attribute::getByProductId($id);
        return $product;
    }

    public static function getAll(): array
    {
        $rows = static::fetchListingRows();

        return array_map(fn($row) => static::mapRow($row), $rows);
    }

    protected static function fetchListingRows(): array
    {
        return static::$connection->createQueryBuilder()
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
            ->leftJoin('pg_min', 'product_gallery', 'pg', 'pg.id = pg_min.min_id')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    protected static function mapRow(array $row): static
    {
        $product = static::hydrate($row);
        $product->price = ProductPrice::hydrate($row);

        $product->gallery = $row['image_url'] ? [$row['image_url']] : [];
        $product->attributes = [];

        return $product;
    }

}