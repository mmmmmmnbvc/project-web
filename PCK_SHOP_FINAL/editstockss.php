<?php include "connect.php" ?>
      <?php
// ตรวจสอบว่ามีการส่งค่ามาหรือไม่
if (isset($_POST['name_food'], $_POST['price'], $_POST['calorie'], $_POST['typ_id'], $_POST['id'])) {
    // เชื่อมต่อฐานข้อมูล
    $stmt = $pdo->prepare("UPDATE Menu_PCK SET name_food = ?, price = ?, calorie = ?, typ_id = ? WHERE id = ?");

    // ผูกค่าจากฟอร์มกับพารามิเตอร์ใน SQL
    $stmt->bindParam(1, $_POST["name_food"]);
    $stmt->bindParam(2, $_POST["price"]);
    $stmt->bindParam(3, $_POST["calorie"]);
    $stmt->bindParam(4, $_POST["typ_id"]);
    $stmt->bindParam(5, $_POST["id"]); // ใช้ ID เป็นตัวกรองในการอัปเดต

    // ดำเนินการคำสั่ง SQL
    if ($stmt->execute()) {
        header("Location: editstock.php");

    } else {
        echo "ไม่สามารถแก้ไขข้อมูลได้";
    }
}
?>