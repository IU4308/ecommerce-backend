<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class SelectedAttributeInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'SelectedAttributeInput',
            'fields' => [
                'attributeName' => Type::nonNull(Type::string()),
                'itemId' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}
