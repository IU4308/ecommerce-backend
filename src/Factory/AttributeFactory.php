<?php

namespace App\Factory;

use App\Model\Attribute;
use App\Service\AttributeService;
use Doctrine\DBAL\Connection;

class AttributeFactory
{
    public function __construct(private Connection $connection)
    {
    }

    /**
     * @return Attribute[]
     */
    public function loadMany(string $productId, $method): array
    {
        $service = new AttributeService($this->connection);
        $rows = $service->$method($productId);
        return Attribute::groupAttributes($rows);
    }
}
