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

    public function createMany(int $orderId, array $items): array
    {
        /** @var OrderItemService $service */
        $service = $this->service;
        $firstItemId = $service->insertMany($orderId, $items);
        return $this->hydrateWithGeneratedIds($items, $firstItemId);
    }

    /**
     * Hydrates items using the first auto-incremented ID.
     *
     * @param array $items
     * @param int $firstId
     * @return OrderItem[]
     */
    private function hydrateWithGeneratedIds(array $items, int $firstId): array
    {
        return array_map(
            fn($item, $i) => OrderItem::hydrate([
                'id' => $firstId + $i,
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
            ]),
            $items,
            array_keys($items)
        );
    }
}
