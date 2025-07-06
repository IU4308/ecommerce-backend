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


    public function load(string $id, string $method = 'get'): Product
    {
        $product = parent::load($id);
        $product->price = (new PriceFactory($this->connection))->load($id);
        $product->gallery = (new GalleryFactory($this->connection))->loadMany($id);
        $product->attributes = (new AttributeFactory($this->connection))->loadMany($id);
        return $product;
    }

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
