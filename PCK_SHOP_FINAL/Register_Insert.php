<?php include "connect.php"; ?>
<?php
try {
    $stmt = $pdo->prepare("INSERT INTO User_PCK (username,password,name_cus,surname_cus,address,phonenumber,email,role) VALUES (?, ?, ?, ?, ?, ?, ?, 'user')");
    $stmt->bindParam(1, $_POST["username"]);
    $stmt->bindParam(2, $_POST["password"]);
    $stmt->bindParam(3, $_POST["name_cus"]);
    $stmt->bindParam(4, $_POST["surname_cus"]);
    $stmt->bindParam(5, $_POST["address"]);
    $stmt->bindParam(6, $_POST["phonenumber"]);
    $stmt->bindParam(7, $_POST["email"]);
    $stmt->execute(); 
    $pid = $pdo->lastInsertId();
    header("Location: login.html");
} catch (PDOException $e) {
    echo "เข้าสู่ระบบสำเร็จ<br>";
    echo "<a href='login.html'>ไปยังหน้าหลักของผู้ใช้</a>";
}
?>
