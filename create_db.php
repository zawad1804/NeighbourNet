<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS neighbournet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "Database 'neighbournet' created successfully!";
} catch (PDOException $e) {
    echo "Database creation failed: " . $e->getMessage();
}
