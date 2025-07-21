<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Config;
use App\Config\Database;
use App\Controller\GraphQL;
use App\Model\Model;


header('Content-Type: application/json; charset=utf-8');

$config = new Config(__DIR__ . '/../');
$frontendUrl = $config->get('FRONTEND_URL');
header("Access-Control-Allow-Origin: $frontendUrl");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

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
