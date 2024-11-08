<?php
session_start();

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
$amount = isset($_GET['amount']) ? $_GET['amount'] : null;

if (!$order_id || !$amount) {
    echo "ข้อมูลการชำระเงินไม่ถูกต้อง";
    exit();
}

// ตรวจสอบว่า QR Code หมดอายุหรือยัง
$expiry_time = isset($_SESSION['expiry_time']) ? $_SESSION['expiry_time'] : (time() + 900); // 15 นาที
$current_time = time();

if ($current_time > $expiry_time) {
    echo "QR Code หมดอายุแล้ว!";
    exit();
}

// ดึงข้อมูล QR Code จาก session
$qr_raw_data = isset($_SESSION['qrRawData']) ? $_SESSION['qrRawData'] : null;
$qr_image = isset($_SESSION['qrImage']) ? $_SESSION['qrImage'] : null;

if (!$qr_raw_data || !$qr_image) {
    echo "ไม่พบข้อมูล QR Code สำหรับการชำระเงิน";
    exit();
}

?>
<head>
    <meta charset="utf-8">
    <title>ชำระเงิน</title>
    <link href="food.css" rel="stylesheet" type="text/css" />
    <link href="footer.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        section.h {
            width: 60%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        img.qr-code {
            width: 300px;
            height: 300px;
            margin-top: 20px;
            border: 5px solid #ddd;
            border-radius: 10px;
        }

        .countdown {
            font-size: 18px;
            font-weight: bold;
            color: #ff4f4f;
            margin-top: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            text-align: center;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        p.amount {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
    <script>
        let countdown = Math.floor(<?php echo $expiry_time - $current_time; ?>);

        function updateCountdown() {
            const countdownDisplay = document.getElementById('countdown');
            if (countdown > 0) {
                countdownDisplay.textContent = countdown + " วินาที";
                countdown--;
            } else {
                countdownDisplay.textContent = "ชำระเงินล้มเหลว: เวลาหมดแล้ว!";
                document.getElementById('payment-form').style.display = 'none'; 
                window.location.href = "statusfaild.html"; 
            }
        }

        setInterval(updateCountdown, 1000);
    </script>
</head>

<body>
<header>
    <h1><a href="shop.php">ร้านอาหารครัวพระจอม</a></h1>
</header>

<nav>
    <h3>
        <a href="food.php">อาหาร</a>
        <a href="Drink.php">เครื่องดื่ม</a>
        <a href="Dessert.php">ของหวาน</a>
    </h3>
</nav>

<section class="h">
    <h1>ชำระเงิน</h1>
    <p class="amount">จำนวนเงิน: <?php echo htmlspecialchars($amount); ?> บาท</p>
    
    <!-- แสดง QR Code ที่ได้จาก SCB -->
    <img class="qr-code" src="data:image/png;base64,<?php echo htmlspecialchars($qr_image); ?>" alt="QR Code สำหรับการชำระเงิน">
    
    <p class="countdown">เวลานับถอยหลัง: <span id="countdown"><?php echo $expiry_time - $current_time; ?> วินาที</span></p>
    <p>สแกน QR code เพื่อชำระเงิน</p>
    
    <form id="payment-form" action="verify_payment.php" method="post">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
        <button type="submit">ยืนยันการชำระเงิน</button>
    </form>
</section>

<footer>
    <div class="footer">
        <div class="sb_footer section_padding">
            <div class="sb_footer-links">
                <div class="sb_footer-links-div">
                    <h4>Categories</h4>
                    <a href="/comics and Novels"><p>Comics and Novels</p></a>
                    <a href="/sciences"><p>Sciences</p></a>
                    <a href="/bussiness and Economics"><p>Business and Economics</p></a>
                </div>
                <div class="sb_footer-links-div">
                    <h4>Help</h4>
                    <a href="/FAQ"><p>FAQ</p></a>
                    <a href="/term of use"><p>Term of use</p></a>
                    <a href="/privacy policy"><p>Privacy policy</p></a>
                </div>
                <div class="sb_footer-links-div">
                    <h4>About us</h4>
                    <a href="/employer"><p>Location</p></a>
                </div>
                <div class="sb_footer-links-div">
                    <h4>Contact</h4>
                    <a href="/about"><p>Facebook</p></a>
                    <a href="/press"><p>Instagram</p></a>
                    <a href="/career"><p>Twitter</p></a>
                    <a href="/contact"><p>Thread</p></a>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
