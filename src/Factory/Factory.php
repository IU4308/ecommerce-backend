<?php

namespace App\Factory;

use Doctrine\DBAL\Connection;

abstract class Factory
{
    public function __construct(protected Connection $connection)
    {
    }

    abstract protected function modelClass(): string;
    abstract protected function serviceClass(): string;

    protected function makeService(): object
    {
        $class = $this->serviceClass();
        return new $class($this->connection);
    }

    public function load(string $id, string $method = 'get'): object
    {
        $service = $this->makeService();
        $row = $service->$method($id);
        return ($this->modelClass())::hydrate($row);
    }

    public function loadMany($arg = null, $method = 'getAll'): array
    {
        $service = $this->makeService();
        $rows = $arg === null
            ? $service->$method()
            : $service->$method($arg);

        return array_map([$this, 'mapRow'], $rows);
    }

    protected function mapRow(array $row): object
    {
        return ($this->modelClass())::hydrate($row);
    }
}
