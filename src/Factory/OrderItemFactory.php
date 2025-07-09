<?php

namespace App\Factory;

use App\Model\OrderItem;
use App\Service\OrderItemService;

class OrderItemFactory extends Factory
{
    protected function modelClass(): string
    {
        return OrderItem::class;
    }

    protected function serviceClass(): string
    {
        return OrderItemService::class;
    }

    /**
     *
     * @param int $orderId
     * @param array $items
     * @return OrderItem[]
     */
    public function createMany(int $orderId, array $items): array
    {
        /** @var OrderItemService $service */
        $service = $this->service;

        $firstItemId = $service->insertMany($orderId, $items);

        return OrderItem::hydrateAllFromInput($items, $firstItemId);
    }
}
