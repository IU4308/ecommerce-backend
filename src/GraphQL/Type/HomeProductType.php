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
                'price' => Type::nonNull(Type::float()),
                'imageUrl' => [
                    'type' => Type::string(),
                    'resolve' => fn($product) => $product->gallery[0] ?? null,
                ],
                'inStock' => Type::nonNull(Type::boolean()),
            ]
        ]);
    }
}
