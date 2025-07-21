<?php

namespace App\Service;

class GalleryService extends Service
{
    protected function getTable(): string
    {
        return 'product_gallery';
    }

    public function getAll($arg = null): array
    {
        return $this->getBy('product_id', $arg);
    }
}
