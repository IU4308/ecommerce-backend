<?php

namespace App\Factory;

use App\Model\Gallery;
use App\Service\GalleryService;

class GalleryFactory extends Factory
{
    protected function resolveModelClass(): string
    {
        return Gallery::class;
    }

    protected function resolveServiceClass(): string
    {
        return GalleryService::class;
    }

}
