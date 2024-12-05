<?php
require 'db_config.php';

header('Content-Type: application/json');

$stmt = $pdo->query("SELECT title, image_path FROM products ORDER BY created_at DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($images);
