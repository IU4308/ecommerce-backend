<?php

namespace App\Config;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Database
{
    private Connection $connection;

    public function __construct(
        private string $host,
        private string $db,
        private string $user,
        private string $pass
    ) {
    }

    public function connect(): Connection
    {
        try {
            $this->connection = DriverManager::getConnection([
                'dbname' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],
                'host' => $_ENV['DB_HOST'],
                'driver' => 'pdo_mysql',
            ]);
            return $this->connection;
        } catch (\Doctrine\DBAL\Exception $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
