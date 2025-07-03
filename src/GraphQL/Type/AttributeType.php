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
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn($attr) => $attr->getName(),
                ],
                'type' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn($attr) => $attr->getType(),
                ],
                'items' => [
                    'type' => Type::listOf(TypeRegistry::attributeItem()),
                    'resolve' => fn($attr) => $attr->getItems(),
                ]
            ]
        ]);
    }
}
