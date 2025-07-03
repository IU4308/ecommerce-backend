<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Product',
            'fields' => function () {
                return [
                    'id' => Type::nonNull(Type::id()),
                    'name' => Type::nonNull(Type::string()),
                    'inStock' => Type::nonNull(Type::boolean()),
                    'description' => Type::nonNull(Type::string()),
                    'category' => Type::nonNull(Type::string()),
                    'brand' => Type::nonNull(Type::string()),
                    'price' => [
                        'type' => TypeRegistry::price(),
                        'resolve' => fn($product) => $product->price,
                    ],
                    'gallery' => [
                        'type' => Type::listOf(Type::string()),
                        'resolve' => fn($product) => $product->gallery,
                    ],
                    'attributes' => [
                        'type' => Type::listOf(new AttributeType()),
                        'resolve' => fn($product) => $product->attributes,
                    ]
                ];
            }
        ]);
    }
}
