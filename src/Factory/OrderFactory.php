<?php

namespace App\Factory;

use App\Model\Order;
use App\Service\OrderService;

class OrderFactory extends Factory
{
    protected function modelClass(): string
    {
        return Order::class;
    }

    protected function serviceClass(): string
    {
        return OrderService::class;
    }

    public function create(array $input): Order
    {
        $orderItemFactory = new OrderItemFactory($this->connection);
        $orderAttributeFactory = new OrderAttributeFactory($this->connection);

        $this->connection->beginTransaction();

        try {
            /** @var OrderService $orderService */
            $orderService = $this->makeService();

            $orderId = $orderService->create();

            $orderItems = $orderItemFactory->createAndInsert($orderId, $input['items']);
            $orderAttributeFactory->createAndInsert($orderItems, $input['items']);

            $this->connection->commit();

            return Order::hydrate([
                'id' => $orderId,
                'created_at' => date('Y-m-d H:i:s'),
                'items' => $orderItems,
            ]);
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

}
