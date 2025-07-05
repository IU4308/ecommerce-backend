<?php

namespace App\Service;

class CategoryService extends Service
{
    protected function table(): string
    {
        return 'categories';
    }

    // public function getById(string $id): ?array
    // {
    //     return $this->getById($id);
    // }

    // public function getAll(): array
    // {
    //     return $this->getAll();
    // }
}
