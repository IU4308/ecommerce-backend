<?php

namespace App\Model\Category;

class ClothesCategory extends BaseCategory
{
    public function getType(): string
    {
        return 'clothes';
    }
}