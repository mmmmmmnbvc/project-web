<?php include "connect.php" ?>
<?php
        $name_food = $_POST["name_food"];
        $price = $_POST["price"];
        $calorie = $_POST["calorie"];
        $typ_id = $_POST["typ_id"];

        $stmt = $pdo->prepare("INSERT INTO Menu_PCK (name_food, price, calorie, typ_id) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $name_food);
        $stmt->bindParam(2, $price);
        $stmt->bindParam(3, $calorie);
        $stmt->bindParam(4, $typ_id);
        $stmt->execute(); // เริ่มเพิ่มข้อมูล
        $pid = $pdo->lastInsertId(); // ขอคีย์หลักที่เพิ่มส าเร็จ
        header("Location: stock.php");
?>
<html>
<head><meta charset="UTF-8"></head>
<body>
</body>
</html>