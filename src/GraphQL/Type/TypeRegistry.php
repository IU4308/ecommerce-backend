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
    private static ?ProductType $product = null;
    private static ?CategoryType $category = null;
    private static ?PriceType $price = null;
    private static ?AttributeType $attribute = null;
    private static ?AttributeItemType $attributeItem = null;

    public static function product(): ProductType
    {
        return self::$product ??= new ProductType();
    }

    public static function category(): CategoryType
    {
        return self::$category ??= new CategoryType();
    }

    public static function price(): PriceType
    {
        return self::$price ??= new PriceType();
    }

    public static function attribute(): AttributeType
    {
        return self::$attribute ??= new AttributeType();
    }

    public static function attributeItem(): AttributeItemType
    {
        return self::$attributeItem ??= new AttributeItemType();
    }
}
