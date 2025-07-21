<?php

namespace App\Service;

class OrderAttributeService extends Service
{
    protected function getTable(): string
    {
        return 'order_attributes';
    }

    public function insertMany(array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        [$placeholders, $params] = $this->buildInsertData($rows);

        $sql = sprintf(
            "INSERT INTO %s (order_item_id, attribute_name, item_id) VALUES %s",
            $this->getTable(),
            implode(', ', $placeholders)
        );

        $this->connection->executeStatement($sql, $params);
    }

    private function buildInsertData(array $rows): array
    {
        $placeholders = [];
        $params = [];

        foreach ($rows as $row) {
            $placeholders[] = '(?, ?, ?)';
            $params[] = $row['order_item_id'];
            $params[] = $row['attribute_name'];
            $params[] = $row['item_id'];
        }

        return [$placeholders, $params];
    }
}
