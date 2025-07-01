<?php

namespace App\GraphQL\Resolver;

use App\Repository\CategoryRepository;

class CategoryResolver
{
    public function __construct(private CategoryRepository $repository)
    {
    }

    public function getCategories(): array
    {
        return $this->repository->getAll();
    }
}
