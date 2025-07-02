<?php

namespace App\Model;

class SwatchAttribute extends Attribute
{
    public function getType(): string
    {
        return 'swatch';
    }
}
