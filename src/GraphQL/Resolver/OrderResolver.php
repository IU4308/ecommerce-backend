<?php

namespace App\GraphQL\Resolver;

use App\Factory\OrderFactory;

class OrderResolver extends Resolver
{
    public function __construct(OrderFactory $factory)
    {
        parent::__construct($factory);
    }

    public function createOrder(array $input): object
    {
        return $this->create($input);
    }
}
