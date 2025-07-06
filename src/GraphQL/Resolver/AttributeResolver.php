<?php

namespace App\GraphQL\Resolver;

use App\Factory\AttributeFactory;

class AttributeResolver
{
    public function __construct(private AttributeFactory $attributeFactory)
    {
    }

    public function getProductAttributes(string $productId): array
    {
        return $this->attributeFactory->loadMany($productId);
    }

}
