<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Config;
use App\Config\Database;
use App\Repository\ProductRepository;
use App\Controller\GraphQL;


$config = new Config(__DIR__ . '/../');
$frontendUrl = $config->get('FRONTEND_URL');

header("Access-Control-Allow-Origin: $frontendUrl");
$db = new Database(
    $config->get('DB_HOST'),
    $config->get('DB_NAME'),
    $config->get('DB_USER'),
    $config->get('DB_PASS')
);
try {
    $GLOBALS['db'] = $db->connect();

    echo GraphQL::handle();
} catch (Throwable $e) {
    echo "<h1>❌ Error:</h1><pre>{$e->getMessage()}</pre>";
}
