<?php

namespace App\Model;

class AttributeItem
{
    public function __construct(
        public readonly string $itemId,
        public readonly string $displayValue,
        public readonly string $value
    ) {
    }
}