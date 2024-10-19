<?php 
include "connect.php";

$id = $_POST['id'];
$nameP = $_POST['nameP'];
$priceP = $_POST['priceP'];
$imageP = $_POST['imageP'];
$descP = $_POST['descP'];
$categoryP = $_POST['categoryP'];

$query = "UPDATE `products`(`name`, `price`, `image`, `content`, `categoryProduct`) VALUES (?, ?, ?, ?, ?) WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssss", $nameP, $priceP, $imageP, $descP, $categoryP, $id);
    $execute = mysqli_stmt_execute($stmt);

    if ($execute) {
        $arr = [
            'success' => true,
            'message' => 'Thêm sản phẩm thành công',

        ];
    } else {
        $arr = [
            'success' => false,
            'message' => 'Thêm sản phẩm không thành công',

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
