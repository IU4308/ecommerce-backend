<?php

namespace App\GraphQL\Type;

use App\GraphQL\Type\AttributeType;
use App\GraphQL\Type\AttributeItemType;
use App\GraphQL\Type\PriceType;

class TypeRegistry
{
    private static ?ProductType $product = null;
    private static ?CategoryType $category = null;
    private static ?PriceType $price = null;
    private static ?AttributeType $attribute = null;
    private static ?AttributeItemType $attributeItem = null;
    private static ?SelectedAttributeInputType $selectedAttributeInput = null;
    private static ?OrderType $order = null;
    private static ?OrderItemInputType $orderItemInput = null;




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

    public static function selectedAttributeInput(): SelectedAttributeInputType
    {
        return self::$selectedAttributeInput ??= new SelectedAttributeInputType();
    }

    public static function order(): OrderType
    {
        return self::$order ??= new OrderType();
    }

    public static function orderItemInput(): OrderItemInputType
    {
        return self::$orderItemInput ??= new OrderItemInputType();
    }
}
