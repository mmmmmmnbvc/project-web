<?php
include "connect.php"; 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $total_price = 0;

    // คำนวณราคาสินค้าทั้งหมดในตะกร้า
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['qty'];
    }

    // ตรวจสอบโค้ดโปรโมชั่น
    $promo_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';
    $discount_amount = 0;

    if (!empty($promo_code)) {
        $sql_promo = "SELECT discount_amount FROM Promotion_PCK WHERE promo_code = ? AND valid_until >= NOW()";
        if ($stmt_promo = $pdo->prepare($sql_promo)) {
            $stmt_promo->bindParam(1, $promo_code, PDO::PARAM_STR);
            $stmt_promo->execute();

            if ($stmt_promo->rowCount() > 0) {
                $row = $stmt_promo->fetch(PDO::FETCH_ASSOC);
                $discount_amount = $row['discount_amount'];
            } else {
                echo "รหัสโปรโมชั่นไม่ถูกต้องหรือหมดอายุ";
            }
        } else {
            echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL สำหรับโปรโมชั่น";
        }
    }

    // คำนวณราคาสุทธิหลังหักส่วนลด
    $final_price = $total_price - $discount_amount;

    $status_food = "Preparing";  // สถานะของอาหาร
    $payment_status = "Unpaid";  // สถานะการชำระเงิน

    // เพิ่มการสั่งซื้อในฐานข้อมูล
    $sql = "INSERT INTO Order_PCK (user_id, status_food, total_price, order_date, payment_status) VALUES (?, ?, ?, NOW(), ?)";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $status_food, PDO::PARAM_STR);
        $stmt->bindParam(3, $final_price, PDO::PARAM_STR);
        $stmt->bindParam(4, $payment_status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // ดึง order_id ที่เพิ่งเพิ่มเข้าไป
            $order_id = $pdo->lastInsertId();

            // ล้างตะกร้าสินค้าหลังจากทำรายการสำเร็จ
            unset($_SESSION['cart']);  // ลบรายการสินค้าในตะกร้า

            // ข้อมูล SCB API credentials
            $applicationKey = 'l7ead960ec62284c9ab908244c619f2453';
            $applicationSecret = 'cd09842105bc41df840621c5301e0796';

            // ฟังก์ชันในการขอ access token
            function getAccessToken($applicationKey, $applicationSecret) {
                $url = 'https://api-sandbox.partners.scb/partners/sandbox/v1/oauth/token';
                $headers = [
                    'Content-Type: application/json',
                    'accept-language: EN',
                    'requestUId: ' . uniqid(),
                    'resourceOwnerId: ' . $applicationKey,
                ];
                $data = json_encode([
                    'applicationKey' => $applicationKey,
                    'applicationSecret' => $applicationSecret,
                ]);
            
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
            
                return json_decode($response, true);
            }
            
            // ฟังก์ชันสร้าง QR Code
            function createQrCode($accessToken, $amount) {
                $url = 'https://api-sandbox.partners.scb/partners/sandbox/v1/payment/qrcode/create';
                $headers = [
                    'Content-Type: application/json',
                    'accept-language: EN',
                    'authorization: Bearer ' . $accessToken,
                    'requestUId: ' . uniqid(),
                    'resourceOwnerId: l7ead960ec62284c9ab908244c619f2453',
                ];
                $data = json_encode([
                    'qrType' => 'PP',
                    'ppType' => 'BILLERID',
                    'ppId' => '532763844410406', // Biller ID
                    'amount' => $amount,
                    'ref1' => 'REFERENCE1',
                    'ref2' => 'REFERENCE2',
                    'ref3' => 'SCB',
                ]);

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                return json_decode($response, true);
            }

            // ขอ access token จาก SCB
            $tokenResponse = getAccessToken($applicationKey, $applicationSecret);
            if ($tokenResponse === null) {
                echo "Error: ไม่สามารถเชื่อมต่อกับ SCB API ได้.";
                exit();
            }
            

            if ($tokenResponse['status']['code'] == 1000) {
                // เก็บ access token ใน session
                $_SESSION['accessToken'] = $tokenResponse['data']['accessToken'];

                // สร้าง QR Code สำหรับยอดชำระเงิน
                $qrResponse = createQrCode($_SESSION['accessToken'], $final_price);

                if ($qrResponse['status']['code'] == 1000) {
                    // เก็บข้อมูล QR Code ใน session
                    $_SESSION['qrRawData'] = $qrResponse['data']['qrRawData'];
                    $_SESSION['qrImage'] = $qrResponse['data']['qrImage'];

                    // เปลี่ยนเส้นทางไปยังหน้าแสดง QR Code
                    $payment_url = "payment_qr.php?order_id=$order_id&amount=$final_price";
                    header("Location: $payment_url");
                    exit();
                } else {
                    echo "Error creating QR Code: " . $qrResponse['status']['description'];
                }
            } else {
                echo "Error getting access token: " . $tokenResponse['status']['description'];
            }
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มการสั่งซื้อ.";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL.";
    }
} else {
    echo "ตะกร้าว่างเปล่า!";
}
?>
