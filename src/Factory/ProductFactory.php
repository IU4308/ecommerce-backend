<?php

namespace App\Factory;

use App\Model\Product;
use App\Model\Price;
use App\Model\Gallery;
use App\Service\ProductService;
use Doctrine\DBAL\Connection;

class ProductFactory extends Factory
{
    protected PriceFactory $priceFactory;
    protected GalleryFactory $galleryFactory;
    protected AttributeFactory $attributeFactory;
    public function __construct(Connection $connection, PriceFactory $priceFactory, GalleryFactory $galleryFactory, AttributeFactory $attributeFactory)
    {
        parent::__construct($connection);
        $this->priceFactory = $priceFactory;
        $this->galleryFactory = $galleryFactory;
        $this->attributeFactory = $attributeFactory;
    }

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
        $product->price = $this->priceFactory->load($id);
        $product->gallery = $this->galleryFactory->loadMany($id);
        $product->attributes = $this->attributeFactory->loadMany($id);
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
