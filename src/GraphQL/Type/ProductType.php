<?php

namespace App\GraphQL\Type;

use App\Model\Product;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Product',
            'fields' => fn() => [
                'id' => Type::nonNull(Type::id()),
                'name' => Type::string(),
                'brand' => Type::string(),
                'category' => Type::string(),
                'description' => Type::string(),
                'inStock' => Type::boolean(),

                // Optional nested data
                'price' => TypeRegistry::price(), // nullable by default
                'gallery' => [
                    'type' => Type::listOf(Type::string()),
                    'resolve' => fn(Product $product) => array_map(fn($g) => $g->imageUrl, $product->gallery),
                ],
                'attributes' => Type::listOf(TypeRegistry::attribute()),
            ],
        ]);
    }
}
