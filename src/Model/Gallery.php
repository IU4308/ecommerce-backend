<?php

namespace App\Model;

class Gallery extends Model
{
    protected static string $table = 'product_gallery';

    public string $id;
    public string $productIid;
    public string $imageUrl;

}