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

        <title>CANCEL JOURNEY</title>
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
        <h1>Cancel Journey</h1>
        <hr class="hr_main">
        <form action="#" method="POST">
            <input style="width: 30%" type="text" placeholder="Enter Journey ID:" name="journeyId">
            <button type="submit" class="canceljourney_tiketbtn" name="cancelJourney">Cancel Journey</button>
        </form>
    </div>

    <footer class="main_footer">
        <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
    </footer>

    </body>
    </html>

<?php

$conn = mysqli_connect("localhost", "root", "", "busdb");
if (isset($_POST['cancelJourney'])) {
    $journeyId = $_POST['journeyId'];

    $deleteJourney = "UPDATE journey SET isCancelled='1' WHERE journeyId='$journeyId';";

    $result = mysqli_query($conn, $deleteJourney);
    if (!$result) {
        echo '<script>
                  if(confirm("Journey can not cancelled !")) {
                            window.location.href = "adminProfile.php"
           }</script>';
         exit();
    } else {

        $findTicketCustomers = "SELECT * FROM ticket WHERE journeyId='$journeyId';";
        $findTicketCustomersConn = mysqli_query($conn, $findTicketCustomers);

        $findReserveCustomers = "SELECT * FROM reservation WHERE journeyId='$journeyId';";
        $findReserveCustomersConn = mysqli_query($conn, $findReserveCustomers);

        $allEmails = "";
        while ($row = mysqli_fetch_assoc($findTicketCustomersConn)) {
            $mailTo = $row['emailaddress'];
            #echo " " . $mailTo;

            $messageID = rand(1000000, 9999999);
            $mailFrom = "kbr.flk@hotmail.com";
            $title_msg = "Journey Cancelled";
            $message = "Your journey cancelled.";
            $feedbackUser = "INSERT INTO message(MessageID, Content,FromEmailAdd,ToEmailAdd,title) VALUES ('$messageID','$message','$mailFrom','$mailTo','$title_msg');";
            $result = mysqli_query($conn, $feedbackUser);
        }

        while ($row2 = mysqli_fetch_assoc($findReserveCustomersConn)) {
            $email = $row2['emaillUser'];
            #echo " " . $email;

            $messageID = rand(1000000, 9999999);
            $mailFrom = "kbr.flk@hotmail.com";
            $title_msg = "Journey Cancelled";
            $message = "Your journey cancelled.";
            $feedbackUser = "INSERT INTO message(MessageID, Content,FromEmailAdd,ToEmailAdd,title) VALUES ('$messageID','$message','$mailFrom','$email','$title_msg');";
            $result = mysqli_query($conn, $feedbackUser);
        }
        #echo "Journey Canceled";
        echo '<script>
                  if(confirm("Journey cancelled, successfully.")) {
                            window.location.href = "adminProfile.php"
           }</script>';
        exit();
    }
}
?>