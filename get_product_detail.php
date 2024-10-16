<?php 
include "connect.php";

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$total = 5; // 5 product/page
$pos = ($page - 1) * $total;
$category = isset($_POST['category']) ? (int)$_POST['category'] : 0;

$stmt = $conn->prepare('SELECT * FROM products WHERE categoryProduct = ? LIMIT ?, ?');
$stmt->bind_param('iii', $category, $pos, $total);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (!empty($data)) {
    $arr = [
        'success' => true,
        'message' => 'Successfully',
        'result' => $data 
    ];
} else {
    $arr = [
        'success' => false,
        'message' => 'Failed',
        'result' => null
    ];
}

echo json_encode($arr);

$stmt->close();
$conn->close();
