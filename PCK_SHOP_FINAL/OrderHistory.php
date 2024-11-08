<?php include "connect.php" ?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Food</title>
    <link href="food.css" rel="stylesheet" type="text/css" />
    <link href="footer.css" rel="stylesheet" type="text/css" />
    <style>

    </style>
  </head>

  <body>
<header>
<h1><a href="shop.php"> ร้านอาหารครัวพระจอม</a>
        <a href="cart.php?action=">
        <svg class="cart" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 1.28125C0 0.677189 0.489689 0.1875 1.09375 0.1875H4.375C4.87689 0.1875 5.31437 0.529075 5.43609 1.01598L6.32272 4.5625H31.7188C32.0464 4.5625 32.3568 4.70942 32.5646 4.96282C32.7723 5.21623 32.8555 5.54944 32.7913 5.87075L30.6038 16.8083C30.5055 17.2994 30.0863 17.661 29.586 17.6861L9.03047 18.7171L9.65773 22.0625H28.4375C29.0416 22.0625 29.5312 22.5522 29.5312 23.1562C29.5312 23.7603 29.0416 24.25 28.4375 24.25H26.25H10.9375H8.75C8.22367 24.25 7.77198 23.8751 7.67498 23.3578L4.39974 5.88988L3.52103 2.375H1.09375C0.489689 2.375 0 1.88531 0 1.28125ZM6.78664 6.75L8.62363 16.5473L28.6258 15.544L30.3846 6.75H6.78664ZM10.9375 24.25C8.52125 24.25 6.5625 26.2088 6.5625 28.625C6.5625 31.0412 8.52125 33 10.9375 33C13.3537 33 15.3125 31.0412 15.3125 28.625C15.3125 26.2088 13.3537 24.25 10.9375 24.25ZM26.25 24.25C23.8338 24.25 21.875 26.2088 21.875 28.625C21.875 31.0412 23.8338 33 26.25 33C28.6662 33 30.625 31.0412 30.625 28.625C30.625 26.2088 28.6662 24.25 26.25 24.25ZM10.9375 26.4375C12.1456 26.4375 13.125 27.4169 13.125 28.625C13.125 29.8331 12.1456 30.8125 10.9375 30.8125C9.72938 30.8125 8.75 29.8331 8.75 28.625C8.75 27.4169 9.72938 26.4375 10.9375 26.4375ZM26.25 26.4375C27.4581 26.4375 28.4375 27.4169 28.4375 28.625C28.4375 29.8331 27.4581 30.8125 26.25 30.8125C25.0419 30.8125 24.0625 29.8331 24.0625 28.625C24.0625 27.4169 25.0419 26.4375 26.25 26.4375Z" fill="white"/>
            </svg>
        </a>

            <a href="Userprofile.php">
                <svg class="user" width="35" height="36" viewBox="0 0 35 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.0625 13.8645C24.0625 17.4889 21.1244 20.427 17.5 20.427C13.8756 20.427 10.9375 17.4889 10.9375 13.8645C10.9375 10.2401 13.8756 7.302 17.5 7.302C21.1244 7.302 24.0625 10.2401 24.0625 13.8645Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 18.2395C0 8.57452 7.83502 0.739502 17.5 0.739502C27.165 0.739502 35 8.57452 35 18.2395C35 27.9045 27.165 35.7395 17.5 35.7395C7.83502 35.7395 0 27.9045 0 18.2395ZM17.5 2.927C9.04314 2.927 2.1875 9.78264 2.1875 18.2395C2.1875 21.8564 3.4415 25.1804 5.53844 27.8004C7.09391 25.2947 10.5101 22.6145 17.5 22.6145C24.4899 22.6145 27.9061 25.2947 29.4616 27.8004C31.5585 25.1804 32.8125 21.8564 32.8125 18.2395C32.8125 9.78264 25.9569 2.927 17.5 2.927Z" fill="white"/>
                </svg>
            </a>

      </h1>
</header>
<nav>
    <h3>
    <a href="food.php"> อาหาร</a>
        <a href="Drink.php"> เครื่องดื่ม</a>
        <a href="Dessert.php"> ของหวาน</a>
    </h3>
</nav>
      <section>
        <div class="h">
            <h1>อาหาร</h1>
        </div>
      </section>
      <article >
      <?php
session_start(); 

if (isset($_SESSION["user_id"])) {

    $user_id = $_SESSION["user_id"];


    $sql = "SELECT Order_PCK.id AS order_id, 
                   Order_Details_PCK.food_id, 
                   Order_Details_PCK.quantity, 
                   Order_Details_PCK.price 
            FROM Order_PCK 
            JOIN Order_Details_PCK ON Order_PCK.id = Order_Details_PCK.order_id 
            WHERE Order_PCK.user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);


    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>รหัสคำสั่งซื้อ</th>
                    <th>รหัสสินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['food_id']}</td>
                    <td>{$row['quantity']}</td>
                    <td>THB " . number_format($row['price'], 2) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "ไม่พบคำสั่งซื้อสำหรับผู้ใช้คนนี้.";
    }
} else {
    echo "ผู้ใช้ไม่ได้ล็อกอิน กรุณาล็อกอินก่อนดูข้อมูล.";
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