<?php

namespace App\Model;

class TextAttribute extends Attribute
{
    public function getType(): string
    {
        return 'text';
    }
}

