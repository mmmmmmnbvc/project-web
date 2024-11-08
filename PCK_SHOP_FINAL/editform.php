<?php include "connect.php" ?>
<?php



$stmt = $pdo->prepare("SELECT * FROM User_PCK WHERE username = ?");
$stmt->bindParam(1, $_GET["username"]);
$stmt->execute();
$row = $stmt->fetch(); 
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Food</title>
    <link href="food.css" rel="stylesheet" type="text/css" />
    <link href="footer.css" rel="stylesheet" type="text/css" />
    <style>
        .profile{
            font-size: 30px;
        }
        .Register {
            text-align: center;
            border: 3px solid white;
            background: linear-gradient(90deg, #3EBB1F 0%, #35C290 100%);
            width: 300px;
            padding: 15px;
            border-radius: 20px;
        }
        /* Add a black background color to the top navigation */
        .topnav {
        background-color: #333;
        overflow: hidden;
        }

        /* Style the links inside the navigation bar */
        .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        }

        /* Add an active class to highlight the current page */
        .active {
        background-color: #04AA6D;
        color: white;
        }

        /* Hide the link that should open and close the topnav on small screens */
        .topnav .icon {
        display: none;
        }

        /* Dropdown container - needed to position the dropdown content */
        .dropdown {
        float: left;
        overflow: hidden;
        }

        /* Style the dropdown button to fit inside the topnav */
        .dropdown .dropbtn {
        font-size: 17px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
        }

        /* Style the dropdown content (hidden by default) */
        .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        }

        /* Style the links inside the dropdown */
        .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
        }

        /* Add a dark background on topnav links and the dropdown button on hover */
        .topnav a:hover, .dropdown:hover .dropbtn {
        background-color: #555;
        color: white;
        }

        /* Add a grey background to dropdown links on hover */
        .dropdown-content a:hover {
        background-color: #ddd;
        color: black;
        }

        /* Show the dropdown menu when the user moves the mouse over the dropdown button */
        .dropdown:hover .dropdown-content {
        display: block;
        }

        /* When the screen is less than 600 pixels wide, hide all links, except for the first one ("Home"). Show the link that contains should open and close the topnav (.icon) */
        @media screen and (max-width: 600px) {
        .topnav a:not(:first-child), .dropdown .dropbtn {
            display: none;
        }
        .topnav a.icon {
            float: right;
            display: block;
        }
        }

        /* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
        @media screen and (max-width: 600px) {
        .topnav.responsive {position: relative;}
        .topnav.responsive a.icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }
        .topnav.responsive .dropdown {float: none;}
        .topnav.responsive .dropdown-content {position: relative;}
        .topnav.responsive .dropdown .dropbtn {
            display: block;
            width: 100%;
            text-align: left;
        }
        }
    </style>
  </head>

  <body>
<header>
    <h1>ร้านอาหารครัวพระจอม
    <a href="logout.php" style="float: right; margin-right: 50px;">
                <svg class="user" width="35" height="36" viewBox="0 0 35 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.0625 13.8645C24.0625 17.4889 21.1244 20.427 17.5 20.427C13.8756 20.427 10.9375 17.4889 10.9375 13.8645C10.9375 10.2401 13.8756 7.302 17.5 7.302C21.1244 7.302 24.0625 10.2401 24.0625 13.8645Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 18.2395C0 8.57452 7.83502 0.739502 17.5 0.739502C27.165 0.739502 35 8.57452 35 18.2395C35 27.9045 27.165 35.7395 17.5 35.7395C7.83502 35.7395 0 27.9045 0 18.2395ZM17.5 2.927C9.04314 2.927 2.1875 9.78264 2.1875 18.2395C2.1875 21.8564 3.4415 25.1804 5.53844 27.8004C7.09391 25.2947 10.5101 22.6145 17.5 22.6145C24.4899 22.6145 27.9061 25.2947 29.4616 27.8004C31.5585 25.1804 32.8125 21.8564 32.8125 18.2395C32.8125 9.78264 25.9569 2.927 17.5 2.927Z" fill="white"/>
                </svg>
    </a>

      </h1>
</header>
<nav>
<div class="topnav" id="myTopnav">
  <a href="Userm.php" class="active">User management</a>
  <div class="dropdown">
    <button class="dropbtn">Order management
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="Orderm.php">รายการรวมของสินค้า</a>
      <a href="Orderpaid.php">รายการที่ชำระเงินแล้ว</a>
      <a href="OrderUnpaid.php">รายการที่ยังไม่ได้ชำระเงิน</a>
    </div>
  </div>
  <a href="Total.php" class="active">Total</a>
  <a href="Totalmonth.php">SOOEM</a>
  <a href="mostorders.php">Most orders</a>
  <a href="stock.php">insert</a>
  <a href="editstock.php">Edit stock</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
</div>
</nav>
      <section>
        <div class="profile">
            <h1>User management</h1>
        </div>
      </section>
      <article>
      <form action="edit-product.php" method="post">
    <input type="hidden" name="old_username" value="<?=$row["username"]?>">
    username:<input type="text" name="username" value="<?=$row["username"]?>"><br>
    password:<input type="text" name="password" value="<?=$row["password"]?>"><br>
    ชื่อ:<input type="text" name="name_cus" value="<?=$row["name_cus"]?>"><br>
    นามสกุล:<input type="text" name="surname_cus" value="<?=$row["surname_cus"]?>"><br>
    ที่อยู่: <input type="text" name="address" value="<?=$row["address"]?>"><br>
    อีเมลล์: <input type="text" name="email" value="<?=$row["email"]?>"><br>
    เบอร์: <input type="text" name="phonenumber" value="<?=$row["phonenumber"]?>"><br>
    <input class='Register' type="submit" value="แก้ไข user">
</form>
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

