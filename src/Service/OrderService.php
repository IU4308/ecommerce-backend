<?php

namespace App\Service;

class OrderService extends Service
{
    protected function table(): string
    {
        return 'orders';
    }

    public function create(): int
    {
        $this->connection->executeStatement("INSERT INTO orders (created_at) VALUES (NOW())");
        return (int) $this->connection->lastInsertId();
    }
}
