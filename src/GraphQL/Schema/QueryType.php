<?php

namespace App\GraphQL\Schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Resolver\ResolverContainer;
use App\GraphQL\Type\TypeRegistry;

class QueryType extends ObjectType
{
    public function __construct(ResolverContainer $resolvers)
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(TypeRegistry::category()),
                    'resolve' => fn() => $resolvers->category()->getCategories(),
                ],
                'products' => [
                    'type' => Type::listOf(TypeRegistry::product()),
                    'resolve' => fn() => $resolvers->product()->getAllProducts()
                ],
                'product' => [
                    'type' => TypeRegistry::product(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => fn($root, $args) => $resolvers->product()->getProduct($args['id']),
                ],
                'productAttributes' => [
                    'type' => Type::listOf(TypeRegistry::attribute()),
                    'args' => [
                        'productId' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => fn($root, $args) => $resolvers->attribute()->getProductAttributes($args['productId']),
                ]
            ],
        ]);
    }
}


