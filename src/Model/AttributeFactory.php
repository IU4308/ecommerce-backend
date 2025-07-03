<?php

namespace App\Model;

class AttributeFactory
{
    public static function make(string $type, string $name, array $items): Attribute
    {
        return match ($type) {
            'swatch' => new SwatchAttribute($name, $type, $items),
            default => new TextAttribute($name, $type, $items),
        };
    }
}
