<?php
session_start();
include("../dbconnect.php");
if (!isset($_SESSION['email'])) {
    $loginError = "You are not logged in";
    echo '<script language="javascript">';
    echo "alert('$loginError')";
    echo '</script>';
    exit();
}

$user = $_SESSION['email'];

$msg = "SELECT * FROM message WHERE ToEmailAdd='$user' ORDER BY Date DESC";
if (isset($conn)) {
$result = mysqli_query($conn, $msg);

if (!$result) {
    #echo "Error, check your code !!!";
    echo '<script language="javascript">';
    echo "alert('Some connection problem!')";
    echo '</script>';
    exit();
}else{

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">

    <title>INFO BOX RU</title>

    <style>
        h2 {
            color: cornflowerblue;
        }

        h8 {
            color: #f44336;
        }


    </style>
</head>
<body>
<!-- Navbar -->
<div class="navbar">
    <!-- Left-aligned links (default) -->
    <a href="../base/homepage_RU.php">Homepage</a>
    <a href="../base/aboutUs_RU.php">About Us</a>
    <a href="../base/contactUs_RU.php">Contact Us</a>
    <a href="../base/support_RU.php">Support</a>

    <!-- Right-aligned links -->
    <div class="navbar-right">
        <a href="registerUserProfile.php"><?php
            $email = $_SESSION['email'];
            $query = "SELECT * FROM users WHERE emailaddress='$email'";
            $queryConn = mysqli_query($conn, $query);

            if (!$queryConn) {
                echo "Error";
            } else {
                while ($row = mysqli_fetch_array($queryConn)) {
                    $name = $row['userName'];
                    echo "Hi! " . $name;
                }
            } ?></a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h1>Messages</h1>
    <hr class="hr_main">
    <h2>From Officer</h2>
    <form method="POST">
        <?php
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <p>Title: <?php echo $row['title'] ?> (<?php echo $row['Date'] ?>)</p>
            <h8> "<?php echo $row['Content'] ?>"</h8>
            <hr>
            <br>
            <?php
        }
        }
        }
        ?>
    </form>
</div>

<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. ?? 2020</h5>
</footer>

</body>
</html>