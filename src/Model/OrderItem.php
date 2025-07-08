<?php

namespace App\Model;

class OrderItem extends Model
{
    public int $id;
    public string $productId;
    public int $quantity;
}