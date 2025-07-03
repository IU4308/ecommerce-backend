<?php

namespace App\GraphQL\Schema;

use App\GraphQL\Resolver\ResolverContainer;
use App\GraphQL\Type\CategoryType;
use App\GraphQL\Type\HomeProductType;
use App\GraphQL\Type\ProductType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct(ResolverContainer $resolvers)
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(new CategoryType()),
                    'resolve' => fn() => $resolvers->category()->getCategories(),
                ],
                'products' => [
                    'type' => Type::listOf(new HomeProductType()),
                    'resolve' => fn() => $resolvers->product()->getAllProducts()
                ],
                'product' => [
                    'type' => new ProductType(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                    'resolve' => fn($root, $args) => $resolvers->product()->getProduct($args['id']),
                ],
            ],
        ]);
    }
}

