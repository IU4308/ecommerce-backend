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

    /**
     * Prepares attribute rows and inserts them.
     */
    public function createAndInsert(array $orderItems, array $itemsInput): void
    {
        $attributeRows = [];
        foreach ($orderItems as $i => $orderItem) {
            foreach ($itemsInput[$i]['selectedAttributes'] ?? [] as $attr) {
                $attributeRows[] = [
                    'order_item_id' => $orderItem->id,
                    'attribute_name' => $attr['attributeName'],
                    'item_id' => $attr['itemId'],
                ];
            }
        }

        /** @var OrderAttributeService $service */
        $service = $this->makeService();
        $service->insertMany($attributeRows);
    }
}
