<?php

namespace App\Model;

use Doctrine\DBAL\Connection;

abstract class Model
{
    protected static Connection $connection;

    public static function setConnection(Connection $conn): void
    {
        static::$connection = $conn;
    }

    // public static function setGlobalConnection(Connection $conn): void
    // {
    //     foreach (get_declared_classes() as $class) {
    //         if (is_subclass_of($class, self::class)) {
    //             $class::setConnection($conn);
    //         }
    //     }
    // }

    public static function hydrate(array $data): static
    {
        $obj = new static();
        $reflection = new \ReflectionClass($obj);

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $camelName = $prop->getName();
            $snakeName = self::camelToSnake($camelName);
            if (array_key_exists($snakeName, $data)) {
                $obj->$camelName = $data[$snakeName];
            }
        }

        return $obj;
    }

    public static function hydrateAll(array $rows): array
    {
        return array_map([static::class, 'hydrate'], $rows);
    }

    protected static function camelToSnake(string $input): string
    {
        return strtolower(preg_replace('/[A-Z]/', '_$0', $input));
    }
}
