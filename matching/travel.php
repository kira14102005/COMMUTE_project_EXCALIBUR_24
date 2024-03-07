<?php
include("../php/server.php");
$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Travel Form</title>
<link rel="stylesheet" type="text/css" href="../styling/style3.css">

<style>
    select#departure-time {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 16px;
        background-color: #f8f8f8;
    }


    select#destination {
        width: 200px; 
        padding: 5px; 
        font-size: 16px; 
        border-radius: 10px;
    }
</style>
</head>
<body>
<div class ="image">
    <a href="../home.php"><img src="../img/logo4.png" alt="LOGO"></a>
</div>
<div class="container">
    <div class="box form-box">
        <header>Choose Your Ride</header>
        <form action="" method="post">
            <div class="dropdown">
                <label for="destination">Destination:</label>
                <select name="destination" id="destination">
                    <option value="Railway Station">Railway Station</option>
                    <option value="Pipli Bus Stand">Pipli Bus Stand</option>
                    <option value="Kurukshetra University 3rd Gate">Kurukshetra University 3rd Gate</option>
                    <option value="Bramhasarovar">Bramhasarovar</option>
                    <option value="Kessel Mall">Kessel Mall</option>
                </select>
            </div>
            <br><br>
            <div class="field input">
                <label type="departure-time" for="departure-time">Departure Time:</label>
                <select type= "departure-time" id="departure-time" name="departure-time"></select>
            </div>
            <br><br>
            <div class="field">
                <input type="submit"  class="btn" name="chose_ride" value="Submit">
            </div>
        </form>
    </div>
</div>

<script>
    var select = document.getElementById("departure-time");
    var select = document.getElementById("departure-time");

for (var hours = 0; hours < 24; hours++) {
    for (var minutes = 0; minutes < 60; minutes += 30) {
        var time = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
        var option = document.createElement('option');
        option.text = time;
        option.value = time;
        select.appendChild(option);
    }
}
</script>
</body>
</html>
