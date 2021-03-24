<?php
session_start();
include("../dbconnect.php");
if (isset($_SESSION)) {

    $journeyId = $_SESSION['journeyId'];

    $seats = $_SESSION['seats'];
    $number  = count($seats);
    $name =$_SESSION['name'];
    $surname=$_SESSION['surname'] ;
    $email=$_SESSION['email'] ;
    $gender=$_SESSION['gender'] ;
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../main.css">
        <title>TICKET PAYMENT BUY G</title>

        <style>
            /* Add padding and center-align text to the container */
            .container-contactUs {
                padding: 60px;
                text-align: center;
            }

            /* The Modal (background) */
            .modal_background_contactUs {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                padding-top: 50px;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
            }

            /* Modal Content/Box */
            .modal-content-contactUs {
                background-color: #87bdd8;
                margin: 5% auto 15% auto;
                border: 1px solid #888;
                width: 50%;
            }

            /* The Modal Close Button (x) */
            .close-contactUs {
                position: absolute;
                right: 35px;
                top: 15px;
                font-size: 40px;
                font-weight: bold;
                color: #f1f1f1;
            }

        </style>
    </head>
    <body>


    <div class="navbar">

        <!-- Left-aligned links (default) -->
        <a href="../base/homepage_G.php">Homepage</a>
        <a href="../base/aboutUs_G.php">About Us</a>

        <a onclick="document.getElementById('id01').style.display='block'">Contact Us</a>
        <div id="id01" class="modal_background_contactUs">
            <span onclick="document.getElementById('id01').style.display='none'" class="close-contactUs"
                  title="Close Modal">×</span>
            <form class="modal-content-contactUs">
                <div class="container-contactUs">
                    <h1 style="color: blanchedalmond">You cannot use contact us</h1>
                    <p> You must be registered into website</p>
                </div>
            </form>
        </div>

        <a href="../base/support_G.php">Support</a>

        <!-- Right-aligned links -->
        <div class="navbar-right">
            <a href="../login.php">Login</a>
            <a href="../registration.php">Registration</a>
        </div>

    </div>

    <div class="container">
        <h1>Ticket Payment For Buying</h1>
        <hr class="hr_main">
    <h3>Total Ücret:<?php
    $query2 = "SELECT * FROM journey WHERE journeyId='$journeyId'";
    if (isset($conn)) {
        $output2 = mysqli_query($conn, $query2);

        if (!$output2) {
            echo 'error';
        } else {
            while ($row2 = mysqli_fetch_array($output2)) {
                $price = $row2['price'];
                $newprice = $price*$number;
                echo $newprice;


                ?>
                </h3>

        <form action="#" method="POST">
            <label>Credit Card Number :</label>
            <input style="width: 30%" type="text" placeholder="Enter CC Number" name="CCNumber" id="CCNumber" required
                   minlength="5" maxlength="15">
            <button style="width: 10%" type="submit" name="paymentbutton" class="CCNumbers"><a>Apply</a></button>
        </form>
    </div>

    <footer class="main_footer">
        <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
    </footer>

    </body>
    </html>

    <?php



                if (isset($_POST['paymentbutton'])) {
                    $CCNumber = $_POST['CCNumber'];
                    $ccn = "SELECT * FROM payment WHERE CCNumber='$CCNumber'";
                    $res = mysqli_query($conn, $ccn);
                    if (!$res) {
                        echo '<script> 
                               if(confirm("Wrong Credit Card Number !\nDo you want to continue?")) {
                                    window.location.href = "ticketPayment_G.php"
                              }</script>';
                        exit();
                    } else {
                        while ($row3 = mysqli_fetch_array($res)) {
                            $balance = $row3['balance'];
                            if ($row3['balance'] < $price) {
                                echo '<script> 
                                        if(confirm("Your balance have not enough money !\nDo you want to continue?")) {
                                            window.location.href = "../base/homepage_G.php"
                                      }</script>';
                                exit();
                            } else {
                                $balance -= $price;
                                $balanceUpdate = "UPDATE payment SET balance='$balance' WHERE CCNumber='$CCNumber'";
                                $output3 = mysqli_query($conn, $balanceUpdate);
                                if (!$output3) {
                                    echo '<script> 
                                        if(confirm("Your ticket purchase is not complete !\nDo you want to continue?")) {
                                            window.location.href = "../base/homepage_G.php"
                                      }</script>';
                                    exit();
                                } else {
                                    #echo "Payment Finished";


                                    $arr = array();
                                    for($k=0;$k<$number;$k++) {
                                        $PNR = rand(10000000, 99999999);
                                        $ticket = array($name["$k"],$surname[$k],$email[$k],$gender[$k],$seats[$k],$PNR);

                                        $arr[$k] = $ticket;



                                    }
                                    $_SESSION['arr'] = $arr;


                                    $journeyId = $_SESSION['journeyId'];
                                    $ticketType = "GuestBuy";




                                    foreach ($arr as $key => $value) {
                                                $regUserTicket= "INSERT INTO ticket(journeyId, name, surname, emailaddress, ticketType, PNR,seatId, gender)
                                            VALUES($journeyId,'$value[0]','$value[1]','$value[2]','$ticketType',$value[5],$value[4],'$value[3]') " ;
                                                if (isset($conn)) {

                                                    $insertTicketTable = mysqli_query($conn, $regUserTicket);

                                                    if (!$insertTicketTable ) {
                                                        echo "SQL error, check your code! ";
                                                    }
                                                }


                                    }


                                    $_SESSION['journeyId'] = $journeyId;
                                    $_SESSION['arr'] =$arr;
                                    echo '<script> window.location.href = "finishedBuyTicket_G.php"</script>';
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

<script>
    var modal = document.getElementById('id01');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>