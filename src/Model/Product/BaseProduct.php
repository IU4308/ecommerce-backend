<?php

namespace App\Model\Product;
abstract class BaseProduct
{
    abstract public function get(mixed $context = null): mixed;
}