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
<form method="POST">
    <div class="container">
        <h1>Add Campaign</h1>
        <hr class="hr_main">
        <label><b>Campaign Id</b></label>
        <input id="campaign_topic" type="text" placeholder="Campaign Topic" name="id_campaign">
        <br> <br>
        <label><b>Campaign Content</b></label>
        <textarea class="msg_content" id="text_classic" placeholder="Write Campaign..." name="content"
                  required></textarea>

        <button type="submit" class="addjourneybtn" name="add_campaign">Save</button>
    </div>
</form>
<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>

<?php

if (isset($_POST['add_campaign'])) {

    $id = $_POST['id_campaign'];
    $content = $_POST['content'];

    $addCampaign = "INSERT INTO campaign(campaignId, campaignContent) VALUES ('$id','$content')";
    if (isset($conn)) {
        $result = mysqli_query($conn, $addCampaign);

        if (!$result) {
            #echo "SQL error!";
            echo '<script> 
                     if(confirm("Campaign is not add !")) {
                               window.location.href = "adminProfile.php"
              }</script>';
            exit();
        } else {
            #echo "New campaign added, successfully.";
            echo '<script> 
                     if(confirm("New campaign added, successfully.")) {
                               window.location.href = "adminProfile.php"
              }</script>';
            exit();
        }
    }

}
?>