<?php
include "connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = $_POST['email'];

// Kiểm tra email
$stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$data = $stmt->get_result();

$result = [];
while ($row = $data->fetch_assoc()) {
    $result[] = $row;
}

if (empty($result)) {
    $arr = [
        'success' => false,
        'message' => 'Email chưa được đăng ký. Vui lòng kiểm tra lại!',
        'result' => $result
    ];
    echo json_encode($arr);
} else {
    $password = $result[0]["password"];
    $link = "<a href='http://192.168.1.218/AppSell/reset_pass.php?key=" . urlencode($email) . "&reset=" . urlencode($password) . "'>Click To Reset password</a>";

    $mail = new PHPMailer();
    $mail->CharSet = "utf-8";
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "nongsanviet.bdh@gmail.com";
    $mail->Password = "iqlu icfw qopl lvhk";
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->From = "nongsanviet.bdh@gmail.com";
    $mail->FromName = 'App Sell';
    $mail->addAddress($email, 'Receiver');
    $mail->Subject = 'Đặt lại mật khẩu App Sell';
    $mail->isHTML(true);
    $mail->Body = 'Click vào liên kết sau để đặt lại mật khẩu của bạn: ' . $link;

    if ($mail->send()) {
        $arr = [
            'success' => true,
            'message' => 'Vui lòng kiểm tra email và nhấp vào liên kết để đặt lại mật khẩu!',
            'result' => $result
        ];
        echo json_encode($arr);
    } else {
        $arr = [
            'success' => false,
            'message' => "Mail Error: " . $mail->ErrorInfo,
            'result' => $result
        ];
        echo json_encode($arr);
    }
}

$stmt->close();
$conn->close();
