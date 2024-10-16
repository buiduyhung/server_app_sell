<?php 
include "connect.php";

$query = "SELECT * FROM products ORDER BY id DESC";
$data = mysqli_query($conn, $query);

// Initialize result array
$result = array();

// Check if the query executed successfully
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
            'result' => null
        ];
    }
} else {
    $arr = [
        'success' => false,
        'message' => 'Không có dữ liệu về sản phẩm',
        'result' => null
    ];
}

// Output JSON response
echo json_encode($arr);

// Close the database connection
mysqli_close($conn);
