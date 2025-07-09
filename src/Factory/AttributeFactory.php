<?php

namespace App\Factory;

use App\Model\Attribute;
use App\Service\AttributeService;

class AttributeFactory extends Factory
{

    protected function modelClass(): string
    {
        return Attribute::class;
    }

    protected function serviceClass(): string
    {
        return AttributeService::class;
    }
    /**
     * @return Attribute[]
     */
    public function loadMany($arg = null, $method = 'getAll'): array
    {
        $rows = $this->service->$method($arg);
        return Attribute::hydrateAll($rows);
    }
}
