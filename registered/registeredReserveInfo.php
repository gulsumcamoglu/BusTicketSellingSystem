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
if (isset($_SESSION)) {


    $journeyId = $_SESSION['journeyId'];


}
if(isset($_POST['seats'])) {
    $seats = $_POST['seats'];
    $_SESSION['seats']=$seats;
    $number = count($seats);
    echo $number;
    $_SESSION['numSeat']=$number;


} else {
    echo 'Hiç koltuk seçmediniz.';
}


?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../main.css">
        <title>REGISTERED RESERVE INFO</title>

        <style>
            /* The container */
            .cont {
                display: inline-flex;
                position: relative;
                padding-left: 35px;
                margin-bottom: 12px;
                cursor: pointer;
                font-size: 22px;

            }
            /* Hide the browser's default radio button */
            .cont input {
                opacity: 0;
                cursor: pointer;
            }

            /* Create a custom radio button */
            .check {
                position: absolute;
                top: 0;
                left: 0;
                height: 20px;
                width: 20px;
                background-color: darkgray;
                border-radius: 50%;
            }

            /* On mouse-over, add a grey background color */
            .cont:hover input ~ .check {
                background-color: #ccc;
            }

            /* When the radio button is checked, add a blue background */
            .cont input:checked ~ .check {
                background-color: #2196F3;
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

    <form action="finishedReserveTicket_RU.php" method="POST">
        <div class="container">
            <h1>Registered User Information For Reserve Ticket</h1>
            <hr>
            <?php


            foreach($seats as $meyve) {
                echo ' seat ' . $meyve . ' <br/>';



                ?>
            <label><b>Name</b></label>
            <input type="text" placeholder="Enter Name" name="names[]" required>

            <label><b>Surname</b></label>
            <input type="text" placeholder="Enter Surname" name="surnames[]" required>

            <label><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="emaill[]" required>

                <label><b>Gender</b></label>
                <input type="text" placeholder="Enter F for Female / M for Male" name="genders[]" required >


                <br><br><br><br>
            <?php } ?>
            <div class="cancel_signup">
                <button type="button" class="cancelbtn" style="width: 10%; border-radius: 40px"><a
                            href="../base/homepage_RU.php">Return</a></button>
                <button type="submit" class="addjourneybtn" name="registered_reserve">Next</button>
            </div>
        </div>
    </form>

    <footer class="main_footer">
        <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
    </footer>

    </body>
    </html>

<?php



?>