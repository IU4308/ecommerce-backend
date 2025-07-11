<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Config;
use App\Config\Database;
use App\Controller\GraphQL;
use App\Http\Cors;
use App\Model\Model;


$config = new Config(__DIR__ . '/../');
Cors::setHeaders($config);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$db = new Database(
    $config->get('DB_HOST'),
    $config->get('DB_NAME'),
    $config->get('DB_USER'),
    $config->get('DB_PASS')
);
try {
    $connection = $db->connect();

    Model::setConnection($connection);

    echo (new GraphQL())->handle($connection);
} catch (Throwable $e) {
    echo "<h1>❌ Error:</h1><pre>{$e->getMessage()}</pre>";
}
