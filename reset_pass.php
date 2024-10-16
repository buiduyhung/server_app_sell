<?php
include "connect.php";

if (isset($_GET['key']) && isset($_GET['reset'])) {
    $email = $_GET['key'];
    $pass = $_GET['reset'];

    $stmt = $conn->prepare("SELECT email, password FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        ?>
        <form method="post" action="submit_new.php">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <p>Nhập mật khẩu mới</p>
            <input type="password" name="password" required>
            <input type="submit" name="submit_password" value="Đổi mật khẩu">
        </form>
        <?php
    } else {
        echo "Không tìm thấy tài khoản hoặc thông tin không hợp lệ.";
    }

    $stmt->close();
}
$conn->close();
