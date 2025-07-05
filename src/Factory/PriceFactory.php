<?php

namespace App\Factory;

use App\Model\Price;
use App\Service\PriceService;

class PriceFactory extends Factory
{
    protected function modelClass(): string
    {
        return Price::class;
    }

    protected function serviceClass(): string
    {
        return PriceService::class;
    }
}
