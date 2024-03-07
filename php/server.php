<?php
session_start();
include("1.js");
// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'sampledb');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $age = mysqli_real_escape_string($db, $_POST['age']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($name)) { array_push($errors, "Name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($age)) { array_push($errors, "Age is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first flag the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_flag_query = "SELECT * FROM registered WHERE Username='$username' OR Email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_flag_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['Username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['Email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO registered (Username, Name, Email, Age, Password) 
  			  VALUES('$username', '$name','$email', '$age','$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	// $query = "SELECT * FROM registered WHERE username='$username' AND password='$password'";
      	// $results = mysqli_query($db, $query);

    $result = mysqli_query($db,"SELECT * FROM registered WHERE Username='$username' AND Password='$password' ") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if(is_array($row) && !empty($row)){
        $_SESSION['valid'] = $row['Email'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['name'] = $row['Name'];
        $_SESSION['age'] = $row['Age'];
        $_SESSION['id'] = $row['Id'];
        $_SESSION['success'] = "You are now logged in";

    }else{
        echo "<div class='message'>
          <p>Wrong Username or Password</p>
           </div> <br>";

    }
    if(isset($_SESSION['valid'])){
        header("Location: home.php");
    }
  }
}
//travelform
if(isset($_POST['chose_ride'])){
  $user_id = $_SESSION['id']; 
  $destination = $_POST['destination'];
  $time = $_POST['departure-time'];

  // flag if the 'flag' attribute is FALSE for the specified 'Id'
  $flag_query = "SELECT `flag` FROM registered WHERE Id = '$user_id'";
  $flag_result = mysqli_query($db, $flag_query);

  if ($flag_result) {
      $flag_row = mysqli_fetch_assoc($flag_result);
      $flag_value = $flag_row['flag'];

      if ($flag_value == FALSE) {
          // If 'flag' attribute is FALSE, insert values into the 'travelform' table
          $sql_insert_travelform = "INSERT INTO travelform (user_id, dest, time) VALUES ('$user_id', '$destination', '$time')";

          if ($db->query($sql_insert_travelform) === TRUE) {
              // Update the 'flag' attribute to TRUE in the 'registered' table
              $sql_update_flag = "UPDATE registered SET `flag` = TRUE WHERE Id = '$user_id'";
              if ($db->query($sql_update_flag) === TRUE) {
                  echo "<div class='smessage'> 
                          <p>New record created successfully</p>
                        </div> <br>";

                  // JavaScript to delay redirection by 0.7 seconds
                  echo "<script>
                          setTimeout(function() {
                            window.location.href = '../home.php';
                          }, 700);
                        </script>";
              } else {
                  echo "Error updating flag attribute: " . $db->error;
              }
          } else {
              echo "Error inserting record into travelform table: " . $db->error;
          }
      } else {
          // If 'flag' attribute is TRUE, give the user options to update or ignore
          echo "<div class=\"nav\"> 
                  <p>You have already chosen a ride. What would you like to do?</p>
                  <form method='post' action=''>
                    <input type='hidden' name='user_id' value='$user_id'>
                    <input type='hidden' name='destination' value='$destination'>
                    <input type='hidden' name='time' value='$time'>
                    <input type='submit' name='update' class='btn' value='Update my ride'>
                    <input type='submit' name='ignore' class='btn' value='Ignore & Return'>
                  </form>
                </div>";
      }
  } else {
      echo "Error fetching 'flag' attribute: " . mysqli_error($db);
  }
}

// Handle form submission for update or ignore
if (isset($_POST['update'])) {
  $user_id = $_POST['user_id'];
  $destination = $_POST['destination'];
  $time = $_POST['time'];

  // Update the 'flag' attribute to TRUE in the 'registered' table
  $sql_update_flag = "UPDATE registered SET `flag` = TRUE WHERE Id = '$user_id'";
  if ($db->query($sql_update_flag) === TRUE) {
      // Update the destination and time in the 'travelform' table
      $sql_update_travelform = "UPDATE travelform SET dest = '$destination', time = '$time' WHERE user_id = '$user_id'";
      if ($db->query($sql_update_travelform) === TRUE) {
          echo "<div class='smessage'> 
                  <p>Ride selection updated successfully</p>
                </div> <br>";

          // JavaScript to delay redirection by 0.7 seconds
          echo "<script>
                  setTimeout(function() {
                    window.location.href = '../home.php';
                  }, 700);
                </script>";
      } else {
          echo "Error updating travelform details: " . $db->error;
      }
  } else {
      echo "Error updating flag attribute: " . $db->error;
  }
}

if (isset($_POST['ignore'])) {
  // Redirect to home page
  header("Location: ../home.php");
  exit();
}


//delete
if(isset($_POST['delete_ride'])){
    $user_id = $_SESSION['id'];

    // Delete the record from the 'travelform' table for the specified 'user_id'
    $sql_delete_travelform = "DELETE FROM travelform WHERE user_id = '$user_id'";
    if ($db->query($sql_delete_travelform) === TRUE) {
        // Update the 'flag' attribute to FALSE in the 'registered' table
        $sql_update_flag = "UPDATE registered SET `flag` = FALSE WHERE Id = '$user_id'";
        if ($db->query($sql_update_flag) === TRUE) {
            echo "<div class='smessage'> 
                    <p>Ride record deleted successfully</p>
                  </div> <br>";

            echo "<script>
                    setTimeout(function() {
                      window.location.href = 'home.php';
                    }, 700);
                  </script>";
        } else {
            echo "Error updating flag attribute: " . $db->error;
        }
    } else {
        echo "Error deleting ride record: " . $db->error;
    }
}

//GROUPING
if(isset($_POST['group'])) {
  $group_size = $_POST['group_size'];

  // Find records from "travelform" table having the same destination and time to go
  $sql_select_travel = "SELECT dest, time, COUNT(*) AS group_size FROM travelform GROUP BY dest, time HAVING COUNT(*) >= $group_size";
  $result = $db->query($sql_select_travel);

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $destination = $row['dest'];
          $time = $row['time'];
          $group_size = $row['group_size'];

          // Display group members' names from the "registered" table
          echo "<div class=\"nav\"><p>Group with destination: <em>$destination</em> and time: <em>$time</em></p></div>";
          echo "<div class=\"box\"> <ul>";
          $sql_select_users = "SELECT Name FROM registered INNER JOIN travelform ON registered.Id = travelform.user_id WHERE dest = '$destination' AND time = '$time'";
          $users_result = $db->query($sql_select_users);

          if ($users_result->num_rows > 0) {
              while ($user_row = $users_result->fetch_assoc()) {
                  $name = $user_row['Name'];
                  echo "<li>$name</li>";
              }
          }
          echo "</ul> </div>";
          $sql_update_flag = "UPDATE registered SET flag = FALSE WHERE Id IN (SELECT user_id FROM travelform WHERE dest = '$destination' AND time = '$time')";
          if ($db->query($sql_update_flag) === TRUE) {
              // echo "<p>Flag attribute updated for registered in the group.</p>";
          } else {
              echo "Error updating flag attribute: " . $db->error;
          }

          // Remove current travelform records from the travelform table for the group members
          $sql_delete_travel = "DELETE FROM travelform WHERE dest = '$destination' AND time = '$time'";
          if ($db->query($sql_delete_travel) === TRUE) {
              // echo "<p>Travel records removed for the group successfully.</p>";
          } else {
              echo "Error removing travelform records: " . $db->error;
          }
      }
  } else {
    echo "<div class=\"message\"><p>Pardon us!, groups of size: $group_size are currently unavailable</p></div>";
  
      // echo "<script>setTimeout(function(){ window.location.href = '../home.php'; }, 1000);</script>";
  }
}
if (isset($_POST['form_group'])) {
  // Check if flag attribute is "TRUE" for the user Id
  $user_id = $_SESSION['id'];
  $sql_check_flag = "SELECT flag FROM registered WHERE Id = '$user_id'";
  $flag_result = $db->query($sql_check_flag);
  
  if ($flag_result->num_rows > 0) {
      $row = $flag_result->fetch_assoc();
      $flag = $row['flag'];
      if ($flag == TRUE) {
          // Redirect to Group.html if flag is TRUE
          header("Location: matching/group.php");
          exit();
      } else {
          // Give a message to book the ride first and redirect to home.php
          echo "<div class=\"message\"><p>Please book the ride first.</p></div>";
          // echo "<script>setTimeout(function(){ window.location.href = 'home.php'; }, 700);</script>";
      }
  } else {
      echo "<div class=\"message\"><p>User not found.</p></div>";
      echo "<script>setTimeout(function(){ window.location.href = 'home.php'; }, 700);</script>";
  }
}


?>


