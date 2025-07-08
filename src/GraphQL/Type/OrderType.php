<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderType',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'createdAt' => Type::nonNull(Type::string()),
            ]
        ]);
    }
}