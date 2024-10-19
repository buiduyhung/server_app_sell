<?php  
include "connect.php";

$id = $_POST['id'];

$query = "DELETE FROM `products` WHERE `id` = '$id'";
$data = mysqli_query($conn, $query);

if ($data){
    $arr = [
        'success' => true,
        'message' => 'Xóa sản phẩm thành công',
    ];
}else{
    $arr = [
        'success' => false,
        'message' => 'Xóa sản phẩm không thành công',
    ];
}


echo json_encode($arr);
