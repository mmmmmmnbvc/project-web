<?php
include "connect.php";

// ตรวจสอบว่ามีค่า `username` ที่ส่งมาใน URL หรือไม่
if (isset($_GET["username"])) {
    $username = $_GET["username"];

    // คำสั่ง SQL สำหรับลบข้อมูล
    $stmt = $pdo->prepare("DELETE FROM User_PCK WHERE username = ?");
    $stmt->bindParam(1, $username); // กำหนดค่า username ที่จะลบ

    // ดำเนินการลบข้อมูล
    if ($stmt->execute()) {
        // รีไดเรกไปยังหน้า Userm.php หลังจากลบเสร็จ
        header("Location: Userm.php");
        exit; // หยุดการทำงานของสคริปต์
    } else {
        echo "ไม่สามารถลบข้อมูลได้";
    }
} 
?>