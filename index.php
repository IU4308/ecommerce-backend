<?php
$host = '127.0.0.1';
$db = 'mydb';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "<h1>✅ Connected to MySQL</h1>";

    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    $count = $stmt->fetchColumn();
    echo "<p>Products count: $count</p>";
} catch (PDOException $e) {
    echo "<h1>❌ Connection failed:</h1><pre>" . $e->getMessage() . "</pre>";
}
