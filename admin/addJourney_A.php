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

    <title>ADD JOURNEY</title>

    <style>

        input[type=time]{
            width: 100%;
            padding: 13px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: 3px solid #b7d7e8;
            background: #f1f1f1;
            border-radius: 3px;
        }

        input[type=time]:focus{
            background-color: #ddd;
            outline: none;
        }

        #date{
            width: 100%;
            padding: 24px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: 3px solid #b7d7e8;
            background: #f1f1f1;
            border-radius: 3px;
        }

       #date:focus {
            background-color: #ddd;
            outline: none;
        }

        #campaignId{
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: 3px solid #b7d7e8;
            background: #f1f1f1;
            border-radius: 3px;
        }

        #campaignId:focus {
            background-color: #ddd;
            outline: none;
        }

    </style>
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
<form action="#" method="POST">
    <div class="container">
        <h1>Add Journey</h1>
        <hr class="hr_main">

        <label><b>From</b></label>
        <input type="text" placeholder="Enter From" name="from" required>

        <label><b>To</b></label>
        <input type="text" placeholder="Enter To" name="to" required>

        <label><b>Date</b></label>
        <br>
        <input type="date" id="date" placeholder="Enter Date Of Journey" name="date" required>
        <script>
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("date")[0].setAttribute('min', today);
        </script>
        <br>
        <label><b>Time</b></label>
        <input type="time" placeholder="Enter Time" name="time" required>
        <br>
        <label><b>Price</b></label>
        <input type="text" placeholder="Enter Price" name="price" required>
        <br>
        <label><b>Campaign Id</b></label><br>
        <select id="campaignId" name="campaignId" style="width: 30%; background-color: #f1f1f1">
           <?php
           $query = "SELECT * FROM campaign";
           if (isset($conn)) {
               $queryConn = mysqli_query($conn, $query);
               if(!$queryConn){
                   echo "Error";
               } else{
                   while($row = mysqli_fetch_array($queryConn)){
                       $campaignId = $row['campaignId'];
                       $text = $row['campaignContent'];?>

            <option value="<?php $row['campaignId'] ?>"> <?php echo " Campaign ID: " .$campaignId. " -". $text ?> </option>
            <?php
                   }
               }
           }
           ?>

        </select>
        <button type="submit" class="addjourneybtn" name="add_journey">Add Journey</a></button>
    </div>
</form>
<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>

<?php

if (isset($_POST['add_journey'])) {

    $id = mt_rand(100000,999999);
    $from = $_POST['from'];
    $to = $_POST['to'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $campaignId = $_POST['campaignId'];

    $addJourney = "INSERT INTO journey(journeyId,DeparturePlace,DestinationPlace,journeyDate,journeyTime, price, campaignId) VALUES ('$id','$from','$to','$date','$time','$price','$campaignId')";
    if (isset($conn)) {
        $result = mysqli_query($conn, $addJourney);

        if (!$result) {
            //echo "SQL error!";
            echo '<script> 
                     if(confirm("Journey can not add !")) {
                               window.location.href = "adminProfile.php"
              }</script>';
            exit();
        } else {
            //echo "New journey added, successfully.";
            echo '<script>
                          if(confirm("New journey added, successfully.")) {
                                    window.location.href = "adminProfile.php"
                   }</script>';
            exit();
        }
    }
}
?>