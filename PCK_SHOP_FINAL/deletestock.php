<?php
include "connect.php";

// ตรวจสอบว่า `id` มีค่าหรือไม่
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // คำสั่ง SQL สำหรับลบข้อมูล
    $stmt = $pdo->prepare("DELETE FROM Menu_PCK WHERE id = ?");
    $stmt->bindParam(1, $id); // กำหนดค่าของ id ที่จะลบ

    // ดำเนินการลบข้อมูล
    if ($stmt->execute()) {
        // รีไดเรกไปยังหน้า `editstock.php` หลังจากลบเสร็จ
        header("Location: editstock.php");
        exit; // หยุดการทำงานของสคริปต์หลังจาก header
    } else {
        echo "ไม่สามารถลบข้อมูลได้";
    }
}
?>