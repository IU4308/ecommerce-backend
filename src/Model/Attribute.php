<?php

namespace App\Model;

use App\Service\AttributeService;

class Attribute extends Model
{
    protected static string $table = 'product_attributes';

    public string $productId;
    public string $attributeName;
    public string $attributeType;

    /** @var AttributeItem[] */
    public array $items = [];

    // public static function getByProductId(string $productId): array
    // {
    //     $rows = (new AttributeService(static::$connection))->fetchByProductId($productId);
    //     return static::groupAttributes($rows);
    // }

    public static function groupAttributes(array $rows): array
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
            fn($data) => static::withItems($data['row'], $data['items']),
            array_values($grouped)
        );
    }

    public static function withItems(array $row, array $items): static
    {
        $attr = static::hydrate($row);
        $attr->items = $items;
        return $attr;
    }
}