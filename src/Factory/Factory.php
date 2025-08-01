<?php

namespace App\Factory;

use App\Exception\NotFoundException;
use App\Service\Service;
use Doctrine\DBAL\Connection;

abstract class Factory
{
    protected Service $service;
    public function __construct(protected Connection $connection)
    {
        $this->service = $this->makeService();
    }

    abstract protected function resolveModelClass(): string;
    abstract protected function resolveServiceClass(): string;

    protected function makeService(): object
    {
        $class = $this->resolveServiceClass();
        return new $class($this->connection);
    }

    public function load(string $id, string $method = 'get'): object
    {
        $row = $this->service->$method($id);
        if (!$row) {
            throw new NotFoundException("Item with ID $id not found");
        }
        return ($this->resolveModelClass())::hydrate($row);
    }

    public function loadMany($arg = null, $method = 'getAll'): array
    {
        $rows = $arg === null
            ? $this->service->$method()
            : $this->service->$method($arg);

        if (!$rows) {
            throw new NotFoundException("Items not found");
        }
        return array_map([$this, 'mapRow'], $rows);
    }

    protected function mapRow(array $row): object
    {
        return ($this->resolveModelClass())::hydrate($row);
    }
}
