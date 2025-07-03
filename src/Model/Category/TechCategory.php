<?php

namespace App\Model\Category;

class TechCategory extends BaseCategory
{
    public function getType(): string
    {
        return 'tech';
    }
}