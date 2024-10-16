<?php
include "connect.php";

// Lấy dữ liệu từ form
$email = $_POST['email'];
$phone = $_POST['phone'];
$total_price = $_POST['total_price'];
$user_id = $_POST['user_id'];
$address = $_POST['address'];
$quantity = $_POST['quantity'];
$detail = $_POST['detail'];

// Thêm đơn hàng vào bảng orders
$stmt = $conn->prepare('INSERT INTO `orders`(`user_id`, `address`, `email`, `phone`, `quantity`, `total_price`) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('ssssss', $user_id, $address, $email, $phone, $quantity, $total_price);
$insert_success = $stmt->execute();

// Kiểm tra nếu thêm đơn hàng thành công
if ($insert_success) {
    // Lấy order_id của đơn hàng vừa thêm
    $stmt = $conn->prepare('SELECT id as order_id FROM `orders` WHERE `user_id` = ? ORDER BY id DESC LIMIT 1');
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        $order_id = $order['order_id'];

        // Chuyển đổi chi tiết đơn hàng từ JSON sang mảng
        $details = json_decode($detail, true);
        $all_details_success = true;

        // Lặp qua các chi tiết và thêm vào bảng order_details
        foreach($details as $value) {
            $stmt = $conn->prepare('INSERT INTO `order_details`(`order_id`, `product_id`, `quantity`, `price`) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('iiid', $order_id, $value['idProduct'], $value['qty'], $value['priceProduct']);
            $insert_detail_success = $stmt->execute();

            // Kiểm tra nếu có bất kỳ chi tiết nào không thêm được
            if (!$insert_detail_success) {
                $all_details_success = false;
                break;
            }
        }

        // Kết quả cuối cùng
        if ($all_details_success) {
            echo json_encode([
                'success' => true,
                'message' => 'Thêm đơn hàng và chi tiết thành công!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Thêm chi tiết đơn hàng không thành công. Vui lòng kiểm tra lại!'
            ]);
        }

    } else {
        // Trường hợp không lấy được mã đơn hàng
        echo json_encode([
            'success' => false,
            'message' => 'Không lấy được mã đơn hàng. Vui lòng kiểm tra lại!'
        ]);
    }
} else {
    // Trường hợp thêm đơn hàng không thành công
    echo json_encode([
        'success' => false,
        'message' => 'Không thêm được đơn hàng. Vui lòng kiểm tra lại!'
    ]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
