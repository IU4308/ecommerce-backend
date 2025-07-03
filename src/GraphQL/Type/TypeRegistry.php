<?php

namespace App\GraphQL\Type;

use App\GraphQL\Type\AttributeType;
use App\GraphQL\Type\AttributeItemType;
use App\GraphQL\Type\PriceType;
use App\GraphQL\Type\ProductDetailType;
use App\GraphQL\Type\HomeProductType;
// ...add other types

class TypeRegistry
{
    private static array $types = [];

    public static function price(): ProductPriceType
    {
        return self::$types['Price'] ??= new ProductPriceType();
    }

    public static function attribute(): AttributeType
    {
        return self::$types['Attribute'] ??= new AttributeType();
    }

    public static function attributeItem(): AttributeItemType
    {
        return self::$types['AttributeItem'] ??= new AttributeItemType();
    }

    public static function product(): ProductType
    {
        return self::$types['Product'] ??= new ProductType();
    }

    public static function homeProduct(): HomeProductType
    {
        return self::$types['HomeProduct'] ??= new HomeProductType();
    }

    // Add other type getters as needed
}
