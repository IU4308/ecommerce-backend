<?php

namespace App\Factory;

use App\Model\Order;
use App\Service\OrderService;
use Doctrine\DBAL\Connection;

class OrderFactory extends Factory
{
    protected OrderItemFactory $orderItemFactory;
    protected OrderAttributeFactory $orderAttributeFactory;

    public function __construct(
        Connection $connection,
        OrderItemFactory $orderItemFactory,
        OrderAttributeFactory $orderAttributeFactory
    ) {
        parent::__construct($connection);
        $this->orderItemFactory = $orderItemFactory;
        $this->orderAttributeFactory = $orderAttributeFactory;
    }

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
        $this->connection->beginTransaction();

        try {
            $orderId = $this->service->create();

            $items = $input['items'];
            $orderItems = $this->orderItemFactory->createMany($orderId, $items);
            $this->orderAttributeFactory->createMany($orderItems, $items);

            $this->connection->commit();

            return $this->buildModel($orderId, $orderItems);
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    private function buildModel(int $orderId, array $orderItems): Order
    {
        return Order::hydrate([
            'id' => $orderId,
            'created_at' => date('Y-m-d H:i:s'),
            'items' => $orderItems,
        ]);
    }
}


