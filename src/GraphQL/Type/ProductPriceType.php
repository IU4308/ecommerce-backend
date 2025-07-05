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
                'currency_label' => Type::nonNull(Type::string()),
                'currency_symbol' => Type::nonNull(Type::string()),
                'amount' => Type::nonNull(Type::float()),
            ]
        ]);
    }
}
