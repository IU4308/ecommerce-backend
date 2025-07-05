<?php

namespace App\Factory;

use App\Model\Product;
use App\Model\Price;
use App\Model\Gallery;
use App\Service\ProductService;

class ProductFactory extends Factory
{
    protected function modelClass(): string
    {
        return Product::class;
    }

    protected function serviceClass(): string
    {
        return ProductService::class;
    }


    public function load(string $id, string $method = 'getByProductId'): Product
    {
        $product = parent::load($id, 'get');
        $product->price = (new PriceFactory($this->connection))->load($id, $method);
        $product->gallery = (new GalleryFactory($this->connection))->loadMany($id, $method);
        $product->attributes = (new AttributeFactory($this->connection))->loadMany($id, $method);
        return $product;
    }

    // public function loadMany($method = 'getAll', $arg = null): array
    // {
    //     $rows = parent::loadMany($method, $arg);
    //     return array_map([$this, 'mapRow'], $rows);
    // }

    protected function mapRow(array $row): Product
    {
        $product = Product::hydrate($row);
        $product->price = Price::hydrate($row);
        $product->gallery = $row['image_url']
            ? [Gallery::hydrate(['image_url' => $row['image_url']])]
            : [];
        $product->attributes = [];

        return $product;
    }
}
