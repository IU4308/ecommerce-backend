<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

abstract class Service
{

    public function __construct(protected Connection $connection)
    {
    }

    abstract protected function getTable(): string;

    public function get(string $id): ?array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAssociative() ?: null;
    }

    public function getAll($arg = null): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTable())
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function getBy(string $column, mixed $value): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTable())
            ->where("$column = :value")
            ->setParameter('value', $value)
            ->executeQuery()
            ->fetchAllAssociative();
    }

}
