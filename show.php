<?php 
include("php/server.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete Ride</title>
<link rel="stylesheet" type="text/css" href="styling/style3.css">
</head>
<body>
<div class ="image">
        <a href="home.php"><img src="img/logo4.png" alt="LOGO"></a>
    </div>
<div class="container">
    <div class="box form-box">
  
        <div class="current-ride-details">
            <?php
            $user_id = $_SESSION['id'];
            $sql_get_ride = "SELECT * FROM travelform WHERE user_id = '$user_id'";
            $result = $db->query($sql_get_ride);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $destination = $row['dest'];
                $time = $row['time'];

                echo "<div class=\"\"><p>\tYour current ride details:</p> </div>";
                echo "<br>";
                echo "<div class=\"box\"><p>Destination: $destination</p></div>";
                echo "<div class=\"box\"><p>Departure Time: $time</p></div>";

                // Show delete ride option if rides are booked
                echo "<form action=\"\" method=\"post\">";
                echo "<br>";

                echo "<div class=\"\">";
                echo "<p>Are you sure you want to delete your current ride?</p>";
                echo "</div>";
                echo "<br>";

                echo "<input type=\"submit\" class=\"btn\" name=\"delete_ride\" value=\"Yes, Delete Ride\">";
                echo "</form>";
            } else {
                echo "<div class=\"box\"><p>No ride details found.</p></div>";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
