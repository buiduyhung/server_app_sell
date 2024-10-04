<?php 
include "connect.php";

$query = "SELECT * FROM products ORDER BY id DESC";
$data = mysqli_query($conn, $query);
$result = array();

while($row = mysqli_fetch_assoc($data)){
    $result[] = $row;
}

if(!empty($result)){
    $arr = [
        'success' => true,
        'message' => 'Successfully',
        'result' => $result 
    ];
}else{
    $arr = [
        'success' => false,
        'message' => 'Failed',
        'result' => null
    ];
}

print_r(json_encode($arr));