<?php

namespace App\GraphQL\Schema;

use App\GraphQL\Resolver\ResolverContainer;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use Doctrine\DBAL\Connection;

class SchemaBuilder
{
    public static function build(Connection $connection): Schema
    {
        $resolvers = new ResolverContainer($connection);

        return new Schema(
            (new SchemaConfig())
                ->setQuery(new QueryType($resolvers))
                ->setMutation(new MutationType($resolvers))
        );
    }
}
