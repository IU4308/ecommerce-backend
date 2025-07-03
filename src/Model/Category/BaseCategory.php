<?php

namespace App\Model\Category;

abstract class BaseCategory
{
    public function __construct(public readonly string $name)
    {
    }

    abstract public function getType(): string;
}