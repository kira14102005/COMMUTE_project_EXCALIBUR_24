<?php 
//    session_start();

   include("php/server.php");
//    include("styling/style.css");
   $user_id = $_SESSION['id'];

   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/style3.css">
    <title>Home</title>
</head>
<body>
    <?php include("php/errors.php");?>
    
    <div class="nav">

        <div class ="image">
        <a href="home.php"><img src="img/logo4.png" alt="LOGO"></a>
    </div>

        <div class="right-links">

            <?php 
            
            $user_id = $_SESSION['id'];
            $query = mysqli_query($db,"SELECT*FROM registered WHERE Id=$user_id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Name = $result['Name'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                // $res_id = $result['Id'];
            }
            
            echo "<a href='edit.php?Id=$user_id'><button class=\"btn\">Change Profile</button></a>";            ?>
        <!-- <form action="" method="post"> -->
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>
            <a href="matching/travel.php"> <button class="btn">Choose Ride</button> </a>
            <a href="show.php"> <button class="btn">Booked Ride</button> </a>
            <form action="" method="post"><input type="submit" class="btn" name="form_group" value="Form Group" > </form>
            <!-- <a href="matching/travel.php"> <button class="btn">Choose Ride</button> </a> -->


        </div>
    </div>
    <main>

       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
            </div>
            <div class="box">
                <p>Your name is <b><?php echo $res_Name ?></b>.</p>
            </div>
            <div class="box">
                <p>Your email is <b><?php echo $res_Email ?></b>.</p>
            </div>
          </div>
          <div class="bottom">
            <div class="box">
                <p>And you are <b><?php echo $res_Age ?> years old</b>.</p> 
            </div>
          </div>
       </div>
       <!-- <div class="field">
                    <input type="submit" class="btn" name="delete_ride" value="DELETE RIDE" required>
                </div> -->

    </main>
</body>
<footer>
<?php
// session_start();
$_SESSION['id'] = $user_id;
$_SESSION['res_Uname'] = $res_Uname;
?>
</footer>
</html>