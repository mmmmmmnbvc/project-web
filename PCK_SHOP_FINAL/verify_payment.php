<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "connect.php";

session_start();


if (isset($_POST['order_id']) && isset($_POST['amount'])) {
    $order_id = $_POST['order_id'];
    $amount = $_POST['amount'];


    if (isset($_SESSION['expiry_time']) && $_SESSION['expiry_time'] < time()) {
        echo "ชำระเงินล้มเหลว: เวลาหมดแล้ว กรุณาลองใหม่อีกครั้ง";
        exit();
    }


    try {
        $stmt = $pdo->prepare("SELECT * FROM Order_PCK WHERE id = ? AND payment_status = 'Unpaid'");
        $stmt->execute([$order_id]);
        if ($stmt->rowCount() > 0) {

            $stmt = $pdo->prepare("UPDATE Order_PCK SET payment_status = 'Paid' WHERE id = ?");
            $stmt->execute([$order_id]);


            header("Location: statussucceed.html");
            exit();
        } else {
            echo "ชำระเงินล้มเหลว: ไม่พบคำสั่งซื้อหรือคำสั่งซื้อนี้ถูกชำระเงินแล้ว";
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "เกิดข้อผิดพลาดในการดำเนินการ กรุณาลองใหม่ในภายหลัง";
    }
} else {
    echo "Invalid request.";
}
?>