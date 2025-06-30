<?php
$host = '127.0.0.1';
$db = 'mydb';
$user = 'appuser';
$pass = 'apppassword';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4;connect_timeout=2";

// Healthcheck endpoint: ?health
if (isset($_GET['health'])) {
    try {
        $pdo = new PDO($dsn, $user, $pass);
        exit("✅ OK");
    } catch (PDOException $e) {
        http_response_code(500);
        exit("❌ DB connection error");
    }
}

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "<h1>✅ Connected to MySQL</h1>";

    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    $count = $stmt->fetchColumn();
    echo "<p>Products count: $count</p>";
} catch (PDOException $e) {
    echo "<h1>❌ Connection failed:</h1><pre>" . $e->getMessage() . "</pre>";
}
