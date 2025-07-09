<?php

namespace App\Service;

class OrderItemService extends Service
{
    protected function table(): string
    {
        return 'order_items';
    }

    public function insertMany(int $id, array $items): int
    {
        $placeholders = [];
        $params = [];

        foreach ($items as $item) {
            $placeholders[] = '(?, ?, ?)';
            $params[] = $id;
            $params[] = $item['productId'];
            $params[] = $item['quantity'];
        }

        $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES " . implode(', ', $placeholders);
        $this->connection->executeStatement($sql, $params);

        return (int) $this->connection->lastInsertId();
    }
}
