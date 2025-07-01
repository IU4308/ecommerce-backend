<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct(
        private string $host,
        private string $db,
        private string $user,
        private string $pass
    ) {
    }

    public function connect(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4;connect_timeout=2";
        try {
            $this->connection = new PDO($dsn, $this->user, $this->pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            throw new \RuntimeException('❌ DB Connection failed: ' . $e->getMessage());
        }
    }
}
