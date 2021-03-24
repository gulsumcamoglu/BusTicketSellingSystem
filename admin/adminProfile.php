<?php
session_start();
include("../dbconnect.php");
if (!isset($_SESSION['email'])) {
    $loginError = "You are not logged in !";
    echo '<script language="javascript">';
    echo "alert('$loginError')";
    echo '</script>';
    include("../admin/loginAdmin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">

    <title>ADMIN PROFILE</title>
</head>
<body>
<!-- Navbar -->
<div class="navbar">

    <!-- Right-aligned links -->
    <div class="navbar-right">
        <a href="../admin/adminProfile.php">Admin Profile</a>
        <a href="../logout.php">Logout</a>
    </div>

</div>

<div class="container">
    <h1>System Transactions</h1>
    <hr class="hr_main">
    <br>
    <button onclick="window.location.href='addJourney_A.php'" type="submit" class="transactions_admin_btn">Add Journey</button>
    <button onclick="window.location.href='viewJourney_A.php'" type="submit" class="transactions_admin_btn">View Journey</button>
    <button onclick="window.location.href='infoBox_A.php'" type="submit" class="transactions_admin_btn">Look Feedbacks</button>
    <button onclick="window.location.href='addCampaign_A.php'" type="submit" class="transactions_admin_btn">Add Campaign</button>
    <button onclick="window.location.href='cancelTicket_A.php'" type="submit" class="transactions_admin_btn">Cancel Ticket</button>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>
