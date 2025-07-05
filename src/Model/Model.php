<?php

namespace App\Model;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

abstract class Model
{
    protected static Connection $connection;
    protected static string $table;
    public static function setConnection(Connection $conn): void
    {
        static::$connection = $conn;
    }

    public static function setGlobalConnection(Connection $conn): void
    {
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, self::class)) {
                $class::setConnection($conn);
            }
        }
    }

    public static function get(string $id): static
    {
        $row = static::findRowById($id);
        return static::hydrate($row);
    }

    public static function getAll(): array
    {
        return array_map(fn($row) => static::hydrate($row), static::fetchAllRows());
    }

    public static function findBy(array $conditions): array
    {
        $qb = static::query()->select('*');
        foreach ($conditions as $key => $value) {
            $qb->andWhere("t.$key = :$key")->setParameter($key, $value);
        }
        return $qb->executeQuery()->fetchAllAssociative();
    }

    protected static function findRowById(string $id): array
    {
        return static::query()
            ->select('*')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAssociative();
    }

    protected static function fetchAllRows(): array
    {
        return static::query()
            ->select('*')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public static function hydrate(array $data): static
    {
        $obj = new static();
        $reflection = new \ReflectionClass($obj);

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $name = $prop->getName();
            if (array_key_exists($name, $data)) {
                $obj->$name = $data[$name];
            }
        }

        return $obj;
    }

    public static function query(): QueryBuilder
    {
        return static::$connection->createQueryBuilder()->from(static::$table, 't');
    }

}
