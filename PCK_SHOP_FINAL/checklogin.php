<?php
include "connect.php";
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Food</title>
    <link href="footer.css" rel="stylesheet" type="text/css" />
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
        }
        header {
            text-align: center;
            font-style: italic;
        }
        article {
            text-align: center;
            flex-grow: 1; 
            display: flex;
            justify-content: center; 
            align-items: center; 
        }
        .Login {
            text-align: center;
            border: 3px solid white;
            background: linear-gradient(90deg, #3EBB1F 0%, #35C290 100%);
            width: 300px;
            padding: 10px;
            border-radius: 20px;
        }
        .U, .S {
            border: 3px solid black;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 1%;
        }
        .Register {
            text-align: center;
            border: 3px solid white;
            background: linear-gradient(90deg, #3EBB1F 0%, #35C290 100%);
            width: 300px;
            padding: 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>ร้านอาหารครัวพระจอม</h1>
    </header>
    <article>
    <?php
    // Prepare statements to check for both user and admin roles
    $memberStmt = $pdo->prepare("SELECT * FROM User_PCK WHERE username = ? AND password = ?");
    $memberStmt->bindParam(1, $_POST["username"]);
    $memberStmt->bindParam(2, $_POST["password"]);
    $memberStmt->execute();
    $memberRow = $memberStmt->fetch();

    if (!empty($memberRow)) {
        // Set session variables for user
        $_SESSION["fullname"] = $memberRow["name"];
        $_SESSION["username"] = $memberRow["username"];
        $_SESSION["user_id"] = $memberRow["id"]; 
        $_SESSION["role"] = $memberRow["role"]; // Get the user's role from the database

        if ($_SESSION["role"] === 'admin') {
            echo "เข้าสู่ระบบสำเร็จ (ADMIN)<br>";
            header("location: Userm.php");
        } elseif ($_SESSION["role"] === 'user') {
            echo "เข้าสู่ระบบสำเร็จ<br>";
            header("location: shop.php");
        } else {
            echo "ไม่สำเร็จ: บทบาทของผู้ใช้ไม่ถูกต้อง";
            echo "<a href='login.html'>เข้าสู่ระบบอีกครั้ง</a>";
        }
        exit; // Make sure to exit after header redirection
    } else {
        echo "ไม่สำเร็จ ชื่อหรือรหัสผ่านไม่ถูกต้อง";
        echo "<a href='login.html'>เข้าสู่ระบบอีกครั้ง</a>";
    }
    ?>
    </article>
    <footer>
        <div class="footer">
            <div class="sb_footer section_padding">
                <div class="sb_footer-links">
                    <div class="sb_footer-links-div">
                        <h4>Categories</h4>
                        <a href="/comics and Novels">
                            <p>Comics and Novels</p>
                        </a>
                        <a href="/sciences">
                            <p>Sciences</p>
                        </a>
                        <a href="/bussiness and Economics">
                            <p>Business and Economics</p>
                        </a>
                    </div>
                    <div class="sb_footer-links-div">
                        <h4>Help</h4>
                        <a href="/FAQ">
                            <p>FAQ</p>
                        </a>
                        <a href="/term of use">
                            <p>Term of use</p>
                        </a>
                        <a href="/privacy policy">
                            <p>Privacy policy</p>
                        </a>
                    </div>
                    <div class="sb_footer-links-div">
                        <h4>About us</h4>
                        <a href="/employer">
                            <p>Location</p>
                        </a>
                    </div>
                    <div class="sb_footer-links-div">
                        <h4>Contact</h4>
                        <a href="/about">
                            <p>Facebook</p>
                        </a>
                        <a href="/press">
                            <p>Instagram</p>
                        </a>
                        <a href="/career">
                            <p>Twitter</p>
                        </a>
                        <a href="/contact">
                            <p>Thread</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
