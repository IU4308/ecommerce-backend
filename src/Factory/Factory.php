<?php

namespace App\Factory;

use App\Service\Service;
use Doctrine\DBAL\Connection;

abstract class Factory
{
    protected Service $service;
    public function __construct(protected Connection $connection)
    {
        $this->service = $this->makeService();
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
        $row = $this->service->$method($id);
        return ($this->modelClass())::hydrate($row);
    }

    public function loadMany($arg = null, $method = 'getAll'): array
    {
        $rows = $arg === null
            ? $this->service->$method()
            : $this->service->$method($arg);

        return array_map([$this, 'mapRow'], $rows);
    }

    protected function mapRow(array $row): object
    {
        return ($this->modelClass())::hydrate($row);
    }
}
