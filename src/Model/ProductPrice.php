<?php

namespace App\Model;

class ProductPrice
{
    public function __construct(
        public readonly string $productId,
        public readonly string $currencyLabel,
        public readonly string $currencySymbol,
        public readonly float $amount,
    ) {
    }
}