<?php

namespace App\Model;
abstract class Attribute
{
    public function __construct(
        protected string $name,
        protected array $items
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    abstract public function getType(): string;
}
