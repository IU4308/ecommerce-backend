<?php

namespace App\Model;

class Price extends Model
{
    protected static string $table = 'product_prices';
    public string $product_id;
    public string $currencyLabel;
    public string $currencySymbol;
    public float $amount;

}