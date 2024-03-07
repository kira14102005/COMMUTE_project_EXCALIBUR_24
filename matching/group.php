<?php
include("../php/server.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select Grouping Option</title>
<link rel="stylesheet" type="text/css" href="../styling/style3.css">
<style>
    select#group_size {
    width: 200px; 
    padding: 5px; 
    font-size: 16px; 
    border-radius: 10px;
    background: #f7f7f7;
    
}

</style>
</head>
<body>
<div class ="image">
    <a href="../home.php"><img src="../img/logo4.png" alt="LOGO"></a>
</div>
<div class="container">
    <div class="box form-box">
        <header>Select Grouping Option</header>
        <form action="" method="post">
            <div class="field">
                <label for="group_size">Select Group Size:</label>
                <select name="group_size" id="group_size">
                    <option value="2">Group of 2</option>
                    <option value="3">Group of 3</option>
                    <option value="4">Group of 4</option>
                </select>
            </div>
            <div class="field">
                <input type="submit" class="btn" name="group" value="Group">
            </div>
        </form>
    </div>
</div>
</body>
</html>
