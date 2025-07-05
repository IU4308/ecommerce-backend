<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Attribute',
            'fields' => [
                'name' => [
                    'type' => Type::string(),
                    'resolve' => fn($root) => $root->attributeName,
                ],
                'type' => [
                    'type' => Type::string(),
                    'resolve' => fn($root) => $root->attributeType,
                ],
                'items' => Type::listOf(TypeRegistry::attributeItem()),
            ],
        ]);
    }
}

