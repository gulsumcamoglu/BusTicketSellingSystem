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
if(isset($_POST['registered_reserve'] )){
    $seats = $_SESSION['seats'];
    $number  = count($seats);
    $journeyId = $_SESSION['journeyId'];

    $names = $_POST['names'];
    $surnames = $_POST['surnames'];
    $emaill = $_POST['emaill'];
    $genders = $_POST['genders'];




    $arr = array();
    for($k=0;$k<$number;$k++) {
        $reservationId = rand(10000000, 99999999);
        $ticket = array($names["$k"],$surnames[$k],$emaill[$k],$genders[$k],$seats[$k],$reservationId);

        $arr[$k] = $ticket;



    }

    $_SESSION['arr'] = $arr;



    $ticketType = "Reserved";
    #echo $journeyId;
    $isCanceled = 0;

    foreach($arr as $key => $value){


        $regUserTicket = "INSERT INTO reservation(reservationId,journeyId, emaillUser,seatId, name, surname, gender,isCancelled,ticketType)
                            VALUES('$value[5]', '$journeyId','$value[2]','$value[4]','$value[0]','$value[1]', '$value[3]','$isCanceled','$ticketType')";


        if (isset($conn)) {

            $insertTicketTable = mysqli_query($conn, $regUserTicket);

            if (!$insertTicketTable ) {
                #eger sistemdeki kayıtlı bir email ile yapmassan işlemi burası çalışır
                echo '<script> language="javascript">';
                echo "alert('Something wrong !\n Enter the registered email address.')";
                echo '</script>';
                exit();
            }
        }


    }





}

if (isset($_SESSION)) {


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <title>FINISHED RESERVE TICKET RU</title>
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
            if (isset($conn)) {
                $queryConn = mysqli_query($conn, $query);

                if (!$queryConn){
                    echo "Error";
                }else{
                    while($row = mysqli_fetch_array($queryConn)){
                        $name = $row['userName'];
                        echo " ".$name;
                    }
                }
            } ?></a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h1>Reserved Ticket Detail</h1>
    <hr class="hr_main">
    <table id="seats" style="width: 85%">
        <tr style="color: darkred">
            <th>PNR</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
            <th>Time</th>
            <th>Price</th>
            <th>Name</th>
            <th>SeatNo</th>
            <th>Cancel Ticket Action</th>

            <?php
            foreach ($arr as $key => $value){
            $query = "SELECT * FROM journey WHERE journeyId='$journeyId'";
            if (isset($conn)) {
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) {
            ?>
        <tr>
            <td><?php echo $value[5]; ?> </td>
            <td><?php echo $row['DeparturePlace']; ?></td>
            <td><?php echo $row['DestinationPlace']; ?></td>
            <td><?php echo $row['journeyDate']; ?></td>
            <td><?php echo $row['journeyTime']; ?></td>
            <td><?php echo $row['price']; ?> TL</td>
            <td>
                <?php
                $query2 = "SELECT * FROM reservation WHERE journeyId='$journeyId' AND reservationId='$value[5]'  AND name='$value[0]'";
                $result2 = mysqli_query($conn, $query2);
                while ($row2 = mysqli_fetch_array($result2)) {
                    echo $row2['name'];
                }
                ?>
            </td>
            <td>
                <?php
                $query2 = "SELECT * FROM reservation WHERE journeyId='$journeyId' AND reservationId='$value[5]'  AND seatId ='$value[4]'";
                $result2 = mysqli_query($conn, $query2);
                while ($row2 = mysqli_fetch_array($result2)) {
                    echo $row2['seatId'];
                }
                ?>
            </td>
            <td>
                <?php echo "<button type='submit' style=\"background-color: crimson; width: 80%; border-radius: 20px\"><a href='reserveTicketCancel.php'>Cancel Ticket</a></button>"; ?>
            </td>
        </tr>
        <?php
        }
        }
      /*  $_SESSION['journeyId'] = $journeyId;
        $_SESSION['reservationId'] = $reservationId;*/
        }
        }

        unset($_SESSION['names']);
        unset($_SESSION['surnames']);
        unset($_SESSION['genders']);
        unset($_SESSION['seats']);
        unset($_SESSION['emaill']);
        unset($_SESSION['journeyId']);
        unset($_SESSION['arr']);
        ?>
        </tr>
    </table>
</div>


<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>
