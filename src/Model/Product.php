<?php

namespace App\Model;

class Product extends Model
{
    protected static string $table = 'products';

    public string $id;
    public string $name;
    public string $brand;
    public string $category;
    public bool $inStock;
    public string $description = '';

    public ?Price $price = null;
    public array $gallery = [];
    public array $attributes = [];

}