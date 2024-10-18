<?php 
include "connect.php";

$search = $_POST['search'];

if(empty($search)){
    $arr = [
        'success' => false,
        'message' => 'Không thành công'
    ];
}else{
    $query = "SELECT * FROM products WHERE `name` LIKE '%$search%'";
    $data = mysqli_query($conn, $query);
    $result = array();

    if ($data) {
        while ($row = mysqli_fetch_assoc($data)) {
            $result[] = $row;
        }

        if (!empty($result)) {
            $arr = [
                'success' => true,
                'message' => 'Lấy dữ liệu sản phẩm thành công',
                'result' => $result 
            ];
        } else {
            $arr = [
                'success' => false,
                'message' => 'Không có dữ liệu về sản phẩm',
                'result' => $result
            ];
        }
    } else {
        $arr = [
            'success' => false,
            'message' => 'Không có dữ liệu về sản phẩm',
            'result' => $result
        ];
    }
}



echo json_encode($arr);
mysqli_close($conn);
