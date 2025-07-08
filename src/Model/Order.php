<?php

namespace App\Model;

class Order extends Model
{
    public int $id;
    public string $createdAt;
    public array $items = [];

}