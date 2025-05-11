<?php
include 'connectdb.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Sanitize and validate inputs
$id = isset($_POST['id']) ? intval($_POST['id']) : null;
$name = isset($_POST['name']) ? trim($_POST['name']) : null;
$price = isset($_POST['price']) ? floatval($_POST['price']) : null;
$availability = isset($_POST['availability']) ? intval($_POST['availability']) : 0;

if (!$id || !$name || $price === null) {
    echo json_encode(['success' => false, 'message' => 'Missing or invalid required fields']);
    exit;
}

$newImage = null;

if (!empty($_FILES['image']['tmp_name'])) {
    $imageInfo = getimagesize($_FILES['image']['tmp_name']);
    if ($imageInfo === false) {
        echo json_encode(['success' => false, 'message' => 'Invalid image file']);
        exit;
    }

    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    
    $query = "UPDATE drinks SET item_name = ?, price = ?, availability = ?, img = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sdisi", $name, $price, $availability, $imageData, $id);
    
    $newImage = 'data:image/png;base64,' . base64_encode($imageData);
} else {
    $query = "UPDATE drinks SET item_name = ?, price = ?, availability = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sdii", $name, $price, $availability, $id);
}

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'success' => true,
        'newImage' => $newImage
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . mysqli_error($conn)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
