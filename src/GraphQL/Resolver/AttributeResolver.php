<?php

namespace App\GraphQL\Resolver;

use App\Factory\AttributeFactory;

class AttributeResolver extends Resolver
{
    public function __construct(AttributeFactory $factory)
    {
        parent::__construct($factory);
    }
}
