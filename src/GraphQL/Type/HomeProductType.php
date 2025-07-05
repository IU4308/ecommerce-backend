<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class HomeProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'HomeProduct',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'name' => Type::nonNull(Type::string()),
                'brand' => Type::nonNull(Type::string()),
                'category' => Type::nonNull(Type::string()),
                'price' => [
                    'type' => TypeRegistry::price(),
                    'resolve' => fn($product) => $product->price,
                ],
                'imageUrl' => [
                    'type' => Type::string(),
                    'resolve' => fn($product) => $product->gallery[0] ?? null,
                ],
                'in_stock' => Type::nonNull(Type::boolean()),
            ]
        ]);
    }
}
