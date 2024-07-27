<?php
$dsn = "mysql:host=localhost;dbname=blog_database";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn,$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Failed: " . $e->getMessage());
}