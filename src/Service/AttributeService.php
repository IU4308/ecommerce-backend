<?php

namespace App\Service;

class AttributeService extends Service
{
    protected function table(): string
    {
        return 'product_attributes';
    }

    public function getAll($arg = null): array
    {
        return $this->connection->createQueryBuilder()
            ->select('a.product_id', 'a.attribute_name', 'a.attribute_type', 'i.item_id', 'i.display_value', 'i.value')
            ->from('product_attributes', 'a')
            ->leftJoin(
                'a',
                'attribute_items',
                'i',
                'a.product_id = i.product_id AND a.attribute_name = i.attribute_name'
            )
            ->where('a.product_id = :id')
            ->setParameter('id', $arg)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
