<?php

namespace App\GraphQL\Resolver;

use App\Exception\NotFoundException;
use GraphQL\Error\UserError;

abstract class Resolver
{
    protected object $factory;

    public function __construct(object $factory)
    {
        $this->factory = $factory;
    }

    public function getById(string $id): ?object
    {
        if (!method_exists($this->factory, 'load')) {
            throw new \BadMethodCallException('Method load() not implemented in factory.');
        }

        try {
            return $this->factory->load($id);
        } catch (NotFoundException $e) {
            throw new UserError($e->getMessage());
        }
    }

    public function getAll($context = null): array
    {
        if (!method_exists($this->factory, 'loadMany')) {
            throw new \BadMethodCallException('Method loadMany() not implemented in factory.');
        }

        try {
            return $this->factory->loadMany($context);
        } catch (NotFoundException $e) {
            throw new UserError($e->getMessage());
        }
    }

    public function create(array $input): ?object
    {
        if (method_exists($this->factory, 'create')) {
            return $this->factory->create($input);
        }

        throw new \BadMethodCallException('Method create() not implemented in factory.');
    }

    public function getByParentId(string $parentId): array
    {
        if (!method_exists($this->factory, 'loadMany')) {
            throw new \BadMethodCallException('Method loadMany() not implemented.');
        }

        try {
            return $this->factory->loadMany($parentId);
        } catch (NotFoundException $e) {
            throw new UserError($e->getMessage());
        }
    }

}
