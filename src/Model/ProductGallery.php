<?php

namespace App\Model;

class ProductGallery extends Model
{
    protected static string $table = 'product_gallery';

    public string $id;
    public string $product_id;
    public string $image_url;

    public static function getByProductId(string $productId): array
    {
        // Returns array of ProductGallery objects
        return parent::findBy(['product_id' => $productId]);

    }
}