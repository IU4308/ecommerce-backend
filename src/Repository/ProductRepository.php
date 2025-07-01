<?php

namespace App\Repository;

use PDO;

class ProductRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function count(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM products");
        return (int) $stmt->fetchColumn();
    }
}
