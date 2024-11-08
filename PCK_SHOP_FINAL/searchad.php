<?php
include "connect.php";

// รับคำค้นหาจาก URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// เตรียมคำค้นหา SQL โดยใช้ LIKE เพื่อค้นหาผู้ใช้ที่ตรงกับคำค้นหา
$stmt = $pdo->prepare("SELECT * FROM User_PCK WHERE name_cus LIKE :query OR username LIKE :query");
$stmt->execute(['query' => '%' . $query . '%']);

// แสดงผลลัพธ์การค้นหา
while ($row = $stmt->fetch()) {
    echo "username: " . htmlspecialchars($row["username"]) . "<br>";
    echo "password: " . htmlspecialchars($row["password"]) . "<br>";
    echo "ชื่อ: " . htmlspecialchars($row["name_cus"]) . "<br>";
    echo "นามสกุล: " . htmlspecialchars($row["surname_cus"]) . "<br>";
    echo "ที่อยู่: " . htmlspecialchars($row["address"]) . "<br>";
    echo "อีเมลล์: " . htmlspecialchars($row["email"]) . "<br>";
    echo "เบอร์: " . htmlspecialchars($row["phonenumber"]) . "<br>";
    echo "<br>\n";
    echo "<a class='Register' href='editform.php?username=" . htmlspecialchars($row["username"]) . "'>แก้ไข</a> | ";
    echo "<a class='Register' href='delem.php?username=" . htmlspecialchars($row["username"]) . "' onclick='confirmDelete(\"" . htmlspecialchars($row["username"]) . "\")'>ลบ</a>";
    echo "<br><br><br><br>\n";
}
?>
