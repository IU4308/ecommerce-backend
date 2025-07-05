<?php

namespace App\Service;

class GalleryService extends Service
{
    protected function table(): string
    {
        return 'product_gallery';
    }

    public function getByProductId(string $productId): array
    {
        return $this->getBy('product_id', $productId);
    }

}
