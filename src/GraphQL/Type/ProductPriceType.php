<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductPriceType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ProductPrice',
            'fields' => [
                'currencyLabel' => Type::nonNull(Type::string()),
                'currencySymbol' => Type::nonNull(Type::string()),
                'amount' => Type::nonNull(Type::float()),
            ]
        ]);
    }
}
