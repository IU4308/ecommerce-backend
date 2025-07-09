<?php

namespace App\Service;

class OrderItemService extends Service
{
    protected function table(): string
    {
        return 'order_items';
    }

    public function insertMany(int $orderId, array $items): int
    {
        [$placeholders, $params] = $this->buildInsertData($orderId, $items);

        $sql = sprintf(
            "INSERT INTO %s (order_id, product_id, quantity) VALUES %s",
            $this->table(),
            implode(', ', $placeholders)
        );

        $this->connection->executeStatement($sql, $params);

        return (int) $this->connection->lastInsertId();
    }

    private function buildInsertData(int $orderId, array $items): array
    {
        $placeholders = [];
        $params = [];

        foreach ($items as $item) {
            $placeholders[] = '(?, ?, ?)';
            $params[] = $orderId;
            $params[] = $item['productId'];
            $params[] = $item['quantity'];
        }

        return [$placeholders, $params];
    }
}
