<?php

namespace App\GraphQL;

use App\GraphQL\Resolver\ResolverContainer;
use App\GraphQL\Schema\QueryType;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

class SchemaBuilder
{
    public static function build(\PDO $pdo): Schema
    {
        $resolvers = new ResolverContainer($pdo);

        return new Schema(
            (new SchemaConfig())
                ->setQuery(new QueryType($resolvers))
            // ->setMutation(new MutationType($resolvers))
        );
    }
}
