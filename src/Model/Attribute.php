<?php

namespace App\Model;

class Attribute extends Model
{
    public string $productId;
    public string $attributeName;
    public string $attributeType;

    /** @var AttributeItem[] */
    public array $items = [];

    public static function hydrateAll(array $rows): array
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
                $grouped[$name]['items'][] = AttributeItem::hydrate([
                    'item_id' => $row['item_id'],
                    'value' => $row['value'],
                    'display_value' => $row['display_value'],
                ]);
            }

        }

        return array_map(
            fn($data) => static::hydrate($data['row'] + ['items' => $data['items']]),
            array_values($grouped)
        );
    }

    public static function hydrate(array $data): static
    {
        $obj = parent::hydrate($data);

        if (isset($data['items']) && is_array($data['items'])) {
            $obj->items = $data['items'];
        }

        return $obj;
    }
}