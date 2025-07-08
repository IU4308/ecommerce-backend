<?php

namespace App\GraphQL\Schema;

use App\GraphQL\Resolver\ResolverContainer;
use App\GraphQL\Type\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class MutationType extends ObjectType
{
    public function __construct(ResolverContainer $resolvers)
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createOrder' => [
                    'type' => TypeRegistry::order(),
                    'args' => [
                        'items' => Type::nonNull(Type::listOf(
                            Type::nonNull(TypeRegistry::orderItemInput())
                        ))
                    ],
                    'resolve' => fn($root, $args) =>
                        $resolvers->order()->createOrder($args),
                ],
            ],
        ]);
    }
}
