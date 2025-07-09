<?php

namespace App\GraphQL\Resolver;

abstract class Resolver
{
    protected object $factory;

    public function __construct(object $factory)
    {
        $this->factory = $factory;
    }

    public function getById(string $id): ?object
    {
        if (method_exists($this->factory, 'load')) {
            return $this->factory->load(id: $id);
        }

        throw new \BadMethodCallException('Method load() not implemented in factory.');
    }

    public function getAll(): array
    {
        if (method_exists($this->factory, 'loadMany')) {
            return $this->factory->loadMany();
        }

        throw new \BadMethodCallException('Method loadMany() not implemented in factory.');
    }

    public function create(array $input): ?object
    {
        if (method_exists($this->factory, 'create')) {
            return $this->factory->create($input);
        }

        throw new \BadMethodCallException('Method create() not implemented in factory.');
    }

    // Optional helper for factories that load many by parentId, e.g. attributes by productId
    public function getByParentId(string $parentId): array
    {
        if (method_exists($this->factory, 'loadMany')) {
            return $this->factory->loadMany($parentId);
        }

        throw new \BadMethodCallException('Method loadMany() with parent ID not implemented.');
    }
}
