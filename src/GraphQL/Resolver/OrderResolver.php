<?php

namespace App\GraphQL\Resolver;

use App\Factory\OrderFactory;
use App\Model\Order;

class OrderResolver
{
    public function __construct(private OrderFactory $factory)
    {
    }

    public function createOrder(array $input): Order
    {
        return $this->factory->create($input);
    }
}
