<?php
session_start();
include("../dbconnect.php");
if (!isset($_SESSION['email'])) {
    $loginError = "You are not logged in !";
    echo '<script language="javascript">';
    echo "alert('$loginError')";
    echo '</script>';
    include("loginAdmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">

    <title>CANCEL TICKET</title>
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
    <h1>Cancel Ticket</h1>
    <hr class="hr_main">
    <form action="#" method="POST">
        <input style="width: 30%" type="text" placeholder="Enter PNR & Ticket ID:" name="pnr">
        <button type="submit" class="canceljourney_tiketbtn" name="cancelTicket">Cancel Ticket</button>
    </form>
</div>

<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>

<?php

if (isset($_POST['cancelTicket'])) {
    date_default_timezone_set("Europe/Istanbul");
    $pnr = $_POST['pnr'];

    /*Admin can cancel ticket only belong to reg users*/
    if (isset($conn)) {
        $findTicket = "SELECT * FROM ticket  WHERE PNR='$pnr'";
        $findTicketConnect = mysqli_query($conn, $findTicket);

        if (!$findTicketConnect) {
            echo '<script>
                                 if(confirm("Some connection error occurs !\nDo you want to continue?")) {
                                     window.location.href = "../admin/adminProfile.php"
                           }</script>';
            exit();
        } else {
            if ($row = mysqli_fetch_array($findTicketConnect)) {
                $journeyId = $row['journeyId'];

                $getPrice = "SELECT * FROM journey WHERE journeyId='$journeyId'";
                $getPriceConnect = mysqli_query($conn, $getPrice);

                if ($row2 = mysqli_fetch_array($getPriceConnect)) {
                    $price = $row2['price'];
                    $journeyDate = $row2['journeyDate'];

                    $today = strtotime("today");
                    if (($journeyDate < $today) && ($row['ticketType'] == 'Campaign') && ($row['isCancelled'] == '1')) {
                        echo '<script>
                                 if(confirm("Your ticket cannot cancel !\nDo you want to continue?")) {
                                     window.location.href = "../admin/adminProfile.php"
                           }</script>';
                        exit();
                    } else {
                        if (($row['ticketType'] = 'Selling') || ($row['ticketType'] = 'GuestBuy')) {
                            $deleteTicket = "UPDATE ticket SET isCancelled='1', ticketType='Cancelled', seatId='0' WHERE PNR='$pnr';";
                            $result = mysqli_query($conn, $deleteTicket);

                            #return money back to user
                            $getCCN = "SELECT * FROM payment WHERE CCNumber='1122334455'";
                            $resultCCN = mysqli_query($conn, $getCCN);

                            if (!$resultCCN) {
                                echo '<script>
                                 if(confirm("Invalid entry, ticket can not cancel !\nDo you want to continue?")) {
                                     window.location.href = "../admin/adminProfile.php"
                                  }</script>';
                                exit();
                            } else {
                                if ($row3 = mysqli_fetch_array($resultCCN)) {
                                    $balance = $row3['balance'];
                                    $balance -= $price;

                                    $cancelTicket = "UPDATE payment SET balance='$balance' WHERE CCNumber='1122334455'";
                                    $result4 = mysqli_query($conn, $cancelTicket);

                                    echo '<script>
                                    if(confirm("Your ticket canceled, successfully.\nDo you want to continue?")) {
                                        window.location.href = "../admin/adminProfile.php"
                                     }</script>';
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
?>

