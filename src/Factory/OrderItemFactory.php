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
     * Inserts items for the given order ID, then hydrates and returns OrderItem models.
     *
     * @param int $orderId
     * @param array $items Raw input items (with productId, quantity, etc.)
     * @return OrderItem[]
     */
    public function createAndInsert(int $orderId, array $items): array
    {
        /** @var OrderItemService $service */
        $service = $this->makeService();
        // Insert items and get the first inserted ID
        $firstItemId = $service->insertMany($orderId, $items);

        // Hydrate models with assigned IDs
        $orderItems = [];
        foreach ($items as $i => $item) {
            $orderItems[] = OrderItem::hydrate([
                'id' => $firstItemId + $i,
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
            ]);
        }

        return $orderItems;
    }
}
