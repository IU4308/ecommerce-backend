<?php

namespace App\Model;

class ProductPrice extends Model
{
    protected static string $table = 'product_prices';
    public string $product_id;
    public string $currency_label;
    public string $currency_symbol;
    public float $amount;

    public static function getByProductId(string $productId): ProductPrice
    {
        $rows = parent::findBy(['product_id' => $productId]);
        $row = $rows[0];
        return static::hydrate($row);
    }
}