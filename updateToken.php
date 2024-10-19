<?php 
include "connect.php";

$id = $_POST['id'];
$token = $_POST['token'];

$query = "UPDATE `users` SET `token` = ? WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $token, $id);
    $execute = mysqli_stmt_execute($stmt);

    if ($execute) {
        $arr = [
            'success' => true,
            'message' => 'Cập nhật token thành công',
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => 'Cập nhật token không thành công',
        ];
    }

    mysqli_stmt_close($stmt);
} else {
    $arr = [
        'success' => false,
        'message' => 'Không thể chuẩn bị câu truy vấn',
    ];
}

echo json_encode($arr);
mysqli_close($conn);
