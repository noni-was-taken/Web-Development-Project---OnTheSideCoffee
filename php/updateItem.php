<?php
include 'connectdb.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$price = $_POST['price'] ?? null;
$availability = $_POST['availability'] ?? '0';

if (!$id || !$name || !$price) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}


$query = "UPDATE drinks SET item_name = ?, price = ?, availability = ?";
$params = [$name, $price, $availability];
$types = "sdi"; // string, decimal, integer

// image upload
$newImage = null;
if (!empty($_FILES['image']['tmp_name'])) {
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $query .= ", img = ?";
    $params[] = $imageData;
    $types .= "b"; // blob
    
    // This will be used to update the image src on the client
    $newImage = 'data:image/png;base64,' . base64_encode($imageData);
}

$query .= " WHERE id = ?";
$params[] = $id;
$types .= "i"; // integer

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, $types, ...$params);

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