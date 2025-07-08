<?php

namespace App\Service;

use App\Model\OrderItem;

class OrderItemService extends Service
{
    protected function table(): string
    {
        return 'order_items';
    }

    // public function createMany(int $orderId, array $items): array
    // {
    //     $placeholders = [];
    //     $params = [];

    //     foreach ($items as $item) {
    //         $placeholders[] = '(?, ?, ?)';
    //         $params[] = $orderId;
    //         $params[] = $item['productId'];
    //         $params[] = $item['quantity'];
    //     }

    //     $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES " . implode(', ', $placeholders);
    //     $this->connection->executeStatement($sql, $params);

    //     $firstId = (int) $this->connection->lastInsertId();
    //     $hydrated = [];

    //     foreach ($items as $i => $item) {
    //         $hydrated[] = OrderItem::hydrate([
    //             'id' => $firstId + $i,
    //             'product_id' => $item['productId'],
    //             'quantity' => $item['quantity'],
    //         ]);
    //     }

    //     return $hydrated;
    // }

    public function insertMany(int $orderId, array $items): int
    {
        $placeholders = [];
        $params = [];

        foreach ($items as $item) {
            $placeholders[] = '(?, ?, ?)';
            $params[] = $orderId;
            $params[] = $item['productId'];
            $params[] = $item['quantity'];
        }

        $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES " . implode(', ', $placeholders);
        $this->connection->executeStatement($sql, $params);

        return (int) $this->connection->lastInsertId();
    }
}
