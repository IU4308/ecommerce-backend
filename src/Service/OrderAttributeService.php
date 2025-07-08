<?php

namespace App\Service;

class OrderAttributeService extends Service
{
    protected function table(): string
    {
        return 'order_attributes';
    }

    public function insertMany(array $rows): void
    {
        if (!$rows)
            return;

        $placeholders = [];
        $params = [];

        foreach ($rows as $row) {
            $placeholders[] = '(?, ?, ?)';
            $params[] = $row['order_item_id'];
            $params[] = $row['attribute_name'];
            $params[] = $row['item_id'];
        }

        $sql = "INSERT INTO order_attributes (order_item_id, attribute_name, item_id) VALUES " . implode(', ', $placeholders);
        $this->connection->executeStatement($sql, $params);
    }
}
