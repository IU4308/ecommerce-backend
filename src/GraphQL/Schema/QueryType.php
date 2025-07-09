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
                    'resolve' => fn() => $resolvers->category()->getAll(),
                ],
                'products' => [
                    'type' => Type::listOf(TypeRegistry::product()),
                    'resolve' => fn() => $resolvers->product()->getAll()
                ],
                'product' => [
                    'type' => TypeRegistry::product(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => fn($root, $args) => $resolvers->product()->getById($args['id']),
                ],
                'productAttributes' => [
                    'type' => Type::listOf(TypeRegistry::attribute()),
                    'args' => [
                        'productId' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => fn($root, $args) => $resolvers->attribute()->getByParentId($args['productId']),
                ]
            ],
        ]);
    }
}


