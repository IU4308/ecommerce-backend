<?php

namespace App\Service;

class CategoryService extends Service
{
    protected function getTable(): string
    {
        return 'categories';
    }
}
