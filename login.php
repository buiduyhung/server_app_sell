<?php
include "connect.php";

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare('SELECT * FROM users WHERE `email` = ? AND `password` = ?');
$stmt->bind_param('ss', $email, $password);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row; 
}

if (!empty($data)) {
    $arr = [
        'success' => true,
        'message' => 'Đăng nhập thành công!',
        'result' => $data
    ];
} else {
    $arr = [
        'success' => false,
        'message' => 'Tài khoản hoặc mật chưa đúng. Vui lòng kiểm tra lại!'
    ];
}

echo json_encode($arr);

$stmt->close();
$conn->close();
