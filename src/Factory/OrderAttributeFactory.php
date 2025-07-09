<?php

namespace App\Factory;

use App\Model\OrderAttribute;
use App\Service\OrderAttributeService;

class OrderAttributeFactory extends Factory
{
    protected function modelClass(): string
    {
        return OrderAttribute::class;
    }

    protected function serviceClass(): string
    {
        return OrderAttributeService::class;
    }

    public function createMany(array $orderItems, array $itemsInput): void
    {
        $rows = $this->buildAttributeRows($orderItems, $itemsInput);
        /** @var OrderAttributeService $this->service */
        $this->service->insertMany($rows);
    }

    private function buildAttributeRows(array $orderItems, array $itemsInput): array
    {
        $rows = [];

        foreach ($orderItems as $i => $orderItem) {
            foreach ($itemsInput[$i]['selectedAttributes'] ?? [] as $attr) {
                $rows[] = [
                    'order_item_id' => $orderItem->id,
                    'attribute_name' => $attr['attributeName'],
                    'item_id' => $attr['itemId'],
                ];
            }
        }

        return $rows;
    }
}

