<?php 
include "connect.php";

$user_id = $_POST['user_id'];

$query = "SELECT * FROM `orders` WHERE `user_id` = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);

$result = array();

while ($row = mysqli_fetch_assoc($data)) {
    $query2 = "SELECT * FROM `order_details` INNER JOIN `products` ON order_details.product_id = products.id WHERE order_details.order_id = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "i", $row['id']);
    mysqli_stmt_execute($stmt2);
    $data1 = mysqli_stmt_get_result($stmt2);

    $item = array();
    while ($row1 = mysqli_fetch_assoc($data1)) {
        $item[] = $row1;
    }
    
    $row['item'] = $item;
    $result[] = $row;
}

if (!empty($result)) {
    $arr = [
        'success' => true,
        'message' => 'Thành công!',
        'result' => $result 
    ];
} else {
    $arr = [
        'success' => false,
        'message' => 'Không thành công',
        'result' => $result
    ];
}

echo json_encode($arr);
