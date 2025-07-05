<?php

namespace App\Service;

class PriceService extends Service
{
    protected function table(): string
    {
        return 'product_prices';
    }

    public function getByProductId(string $productId): array
    {
        return $this->getBy('product_id', $productId)[0] ?? [];
    }
}
