<?php

namespace App\Factory;

use App\Model\Price;
use App\Service\PriceService;

class PriceFactory extends Factory
{
    protected function resolveModelClass(): string
    {
        return Price::class;
    }

    protected function resolveServiceClass(): string
    {
        return PriceService::class;
    }
}
