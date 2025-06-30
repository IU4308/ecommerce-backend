<?php
$host = '127.0.0.1';
$db = 'mydb';
$user = 'root';
$pass = 'root';
$dsn = "mysql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "✅ Connected to MySQL<br>";

    $stmt = $pdo->query("SELECT * FROM products");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "👤 " . $row['name'] . "<br>";
    }
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
