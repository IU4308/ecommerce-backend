<?php

namespace App\Controller;

use GraphQL\GraphQL as GraphQLBase;
use RuntimeException;
use Throwable;
use App\GraphQL\SchemaBuilder;
use Doctrine\DBAL\Connection;

class GraphQL
{
    public function handle(Connection $connection): string
    {
        try {
            $schema = SchemaBuilder::build($connection);

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false || empty($rawInput)) {
                throw new RuntimeException('No GraphQL input provided.');
            }

            $input = json_decode($rawInput, true);
            if (!isset($input['query'])) {
                throw new RuntimeException('Missing "query" field in GraphQL request.');
            }

            $query = $input['query'];
            $variables = $input['variables'] ?? null;

            $result = GraphQLBase::executeQuery(
                $schema,
                $query,
                null,
                null,
                $variables
            );

            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
