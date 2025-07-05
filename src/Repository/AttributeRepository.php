<?php

namespace App\Repository;

use App\Model\Attribute;
use App\Model\AttributeItem;
use Doctrine\DBAL\Connection;

class AttributeRepository
{
    public function __construct(private Connection $db)
    {
        Attribute::setConnection($db);
    }

    public function get(string $productId): array
    {
        $rows = $this->db->createQueryBuilder()
            ->select('a.product_id', 'a.attribute_name', 'a.attribute_type', 'i.item_id', 'i.display_value', 'i.value')
            ->from('product_attributes', 'a')
            ->leftJoin('a', 'attribute_items', 'i', 'a.product_id = i.product_id AND a.attribute_name = i.attribute_name')
            ->where('a.product_id = :id')
            ->setParameter('id', $productId)
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->buildAttributeModels($rows);
    }

    private function buildAttributeModels(array $rows): array
    {
        $grouped = [];

        foreach ($rows as $row) {
            $name = $row['attribute_name'];

            if (!isset($grouped[$name])) {
                $grouped[$name] = [
                    'row' => [
                        'product_id' => $row['product_id'],
                        'attribute_name' => $name,
                        'attribute_type' => $row['attribute_type'],
                    ],
                    'items' => [],
                ];
            }

            if ($row['item_id']) {
                $grouped[$name]['items'][] = new AttributeItem(
                    itemId: $row['item_id'],
                    value: $row['value'],
                    displayValue: $row['display_value']
                );
            }
        }

        return array_map(
            fn($data) => Attribute::withItems($data['row'], $data['items']),
            array_values($grouped)
        );
    }
}
