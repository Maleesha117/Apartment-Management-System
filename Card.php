<?php
session_start();
require_once('inc/connection.php');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Retrieve additional session data
$username = $_SESSION['username'];
$dp = $_SESSION['Rpic'];
$currentMonth = date('F'); // Get the current month's name
$total = isset($_GET['total']) ? $_GET['total'] : 0;
// Prepare and execute the database query
$sql = "INSERT INTO payment (Rname, Rid, Balance, RMonth) VALUES (?, ?, ?, ?)";
$stmt = $connection->prepare($sql);

// Bind parameters and execute statement
$stmt->bind_param("ssis", $username, $dp, $total, $currentMonth);

if ($stmt->execute()) {
    echo "";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shangri-La Payment Receipt</title>
    <link rel="stylesheet" href="Card.css">
</head>
<body>
    <div class="block">
        <div class="receipt-container">
            <div class="receipt-header">
                <div class="receipt-logo">
                    <img src="https://i.ibb.co/fGLL4nh/0069-HK-BIG.png" alt="Shangri-La Logo" width="150">
                </div>
                <div class="receipt-heading">
                    <h1>Shangri-La Residences at One Galle Face</h1>
                </div>
            </div>
            <div class="receipt-content">
                <!-- This is where the dynamically generated content will go -->
            </div>
        </div>

        <div class="container">
            <div class="card-container">
                <div class="front">
                    <div class="image">
                        <img src="chip.png" alt="Chip" id="chip">

                        <img src="visa copy.png" alt="Visa" id="visa">
                    </div>
                    <div class="card-number-box">
                        ##############
                    </div>
                    <div class="flexbox">
                        <div class="box">
                            <span>Card Holder</span>
                            <div class="card-holder-name">Full Name</div>
                        </div>
                        <div class="box">
                            <span>Expires</span>
                            <div class="expiration">
                                <span class="exp-month">mm</span>
                                <span class="exp-year">yy</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form>
                <div class="inputBox">
                    <span>Card Number</span>
                    <input type="text" maxlength="16" class="card-number-input">
                </div>
                <div class="inputBox">
                    <span>Card Holder</span>
                    <input type="text" class="card-holder-input">
                </div>
                <div class="flexbox">
                    <div class="inputBox">
                        <span>Expiration MM</span>
                        <select class="month-input">
                            <option value="month" selected disabled>Month</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>Expiration YY</span>
                        <select class="year-input">
                            <option value="year" selected disabled>Year</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                            <option value="2032">2032</option>
                            <option value="2033">2033</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>CVV</span>
                        <input type="text" maxlength="4" class="cvv-input">
                    </div>
                </div>
                <input type="submit" value="Submit" class="submit-btn">
            </form>
        </div>
    </div>
    <script src="Cards.js"></script>
</body>
</html>