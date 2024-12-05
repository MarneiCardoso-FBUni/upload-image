<?php
require 'db_config.php';

header('Content-Type: application/json');

// Criar pasta se não existir
$uploadDir = '../img_product/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Validar upload
if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    echo json_encode(['message' => 'Erro no upload.']);
    exit;
}

$allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/svg'];
$fileType = mime_content_type($_FILES['image']['tmp_name']);

if (!in_array($fileType, $allowedTypes)) {
    echo json_encode(['message' => 'Tipo de arquivo não suportado.']);
    exit;
}

$filename = uniqid() . '-' . basename($_FILES['image']['name']);
$targetFile = $uploadDir . $filename;

if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
    echo json_encode(['message' => 'Erro ao salvar o arquivo.']);
    exit;
}

$title = $_POST['title'];
$description = $_POST['description'];
$imagePath = 'img_product/' . $filename;

$stmt = $pdo->prepare("INSERT INTO products (title, description, image_path) VALUES (:title, :description, :image_path)");
$stmt->bindParam(':title', $title);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':image_path', $imagePath);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Upload realizado com sucesso!', 'imagePath' => $imagePath]);
} else {
    echo json_encode(['message' => 'Erro ao salvar no banco de dados.']);
}
