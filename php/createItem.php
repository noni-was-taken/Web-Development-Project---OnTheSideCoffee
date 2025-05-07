<?php
include 'connectdb.php';

// get input
$data = json_decode(file_get_contents('php://input'), true);

// default val
$name = isset($data['name']) ? $data['name'] : 'Edit to Change';
$price = isset($data['price']) ? floatval($data['price']) : 0;
$availability = isset($data['availability']) ? intval($data['availability']) : 0;

// prep to insert
$query = "INSERT INTO drinks (item_name, price, availability) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sdi", $name, $price, $availability);

// Execute the statement
$success = mysqli_stmt_execute($stmt);
$newId = mysqli_insert_id($conn);

// close the statement
mysqli_stmt_close($stmt);

// return the response
header('Content-Type: application/json');
if ($success) {
    echo json_encode([
        'success' => true,
        'id' => $newId,
        'name' => $name,
        'price' => $price,
        'availability' => $availability
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>