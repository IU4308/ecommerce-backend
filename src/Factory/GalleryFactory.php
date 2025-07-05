<?php

namespace App\Factory;

use App\Model\Gallery;
use App\Service\GalleryService;

class GalleryFactory extends Factory
{
    protected function modelClass(): string
    {
        return Gallery::class;
    }

    protected function serviceClass(): string
    {
        return GalleryService::class;
    }

}
