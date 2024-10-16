<?php
include "connect.php";

if (isset($_POST['submit_password']) && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    // $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Chuẩn bị câu lệnh SQL để cập nhật mật khẩu
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $pass, $email);

    if ($stmt->execute()) {
        echo "Mật khẩu đã được cập nhật thành công!";
    } else {
        echo "Có lỗi xảy ra khi cập nhật mật khẩu.";
    }


    $stmt->close();
    $conn->close();
}
