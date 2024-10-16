<?php 
include "connect.php";

$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$phone = $_POST['phone'];

// Prepare a statement to check if the email already exists to prevent SQL injection
$query = 'SELECT * FROM `users` WHERE `email` = ?';
$stmt_check = $conn->prepare($query);
$stmt_check->bind_param('s', $email);
$stmt_check->execute();
$data = $stmt_check->get_result();
$numrow = $data->num_rows;

if ($numrow > 0) {
    $arr = [
        'success' => false,
        'message' => 'Email đã tồn tại',
    ];
} else {
    // Prepare the statement to insert the data
    $stmt = $conn->prepare('INSERT INTO `users`(`email`, `password`, `username`, `phone`) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $email, $password, $username, $phone);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        $arr = [
            'success' => true,
            'message' => 'Đăng ký tài khoản thành công!',
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => 'Đăng ký tài khoản chưa thành công. Vui lòng kiểm tra lại!',
        ];
    }
}

// Return the response as JSON
echo json_encode($arr);

// Close the statement and connection
$stmt_check->close();
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
