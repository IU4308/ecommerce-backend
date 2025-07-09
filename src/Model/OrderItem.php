<?php

namespace App\Model;

class OrderItem extends Model
{
    public int $id;
    public string $productId;
    public int $quantity;

    /**
     * @param array $items
     * @param int $firstId
     * @return static[]
     */
    public static function hydrateAllFromInput(array $items, int $firstId): array
    {
        return array_map(
            fn($item, $i) => static::hydrate(['id' => $firstId + $i, ...$item]),
            $items,
            array_keys($items)
        );
    }
}
