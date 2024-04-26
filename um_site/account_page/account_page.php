<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>
<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
    //var_dump($username);
  $list_of_events = getEventsByAccount($username);
  $list_of_clubs = getClubsByAccount($username);
  //var_dump($list_of_events);

  // Get user information
  $user_info = getAccount($username);
  $first_name = $user_info['first_name'];
  $last_name = $user_info['last_name'];
  $email = $user_info['email'];
  $password = $user_info['password'];
  $censored = str_repeat('*', strlen($password));
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: ../login_page/login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">    
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Upsorn Praphamontripong">
  <meta name="description" content="Maintenance request form, a small/toy web app for ISP homework assignment, used by CS 3250 (Software Testing)">
  <meta name="keywords" content="CS 3250, Upsorn, Praphamontripong, Software Testing">
  <link rel="icon" href="https://www.cs.virginia.edu/~up3f/cs3250/images/st-icon.png" type="image/png" />  
  
  <title>UniMeet</title>
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="../unimeet.css">
</head>

<body>  
  <?php include('../navbar.html') ?> 
  
  <style>
  .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 60vh; /* This will center the container vertically */
  }

  .profile-item {
    margin-bottom: 1.5em; /* This will add more vertical space between the lines */
  }

  input[readonly] {
    background-color: #f0f0f0;
    margin-right: 1em; /* This will add more horizontal space between the text boxes and the edit buttons */
  }

  .btn {
    width: 200px; /* This will make the buttons as large as the text boxes */
  }
</style>
<h1 class="text-center mt-4" style="font-size: 2.5em;">Profile</h1>
<div class="container">
    
    <div class="profile-container text-center" style="font-size: 1.8em;">
      <div class="profile-item">
        First Name: <input type="text" value="Test" readonly> <button class="btn btn-primary edit-button">Edit</button>
      </div>
      <div class="profile-item">
        Last Name: <input type="text" value="User" readonly> <button class="btn btn-primary edit-button">Edit</button>
      </div>
      <div class="profile-item">
        Email: <input type="text" value="test@gmail.com" readonly> <button class="btn btn-primary edit-button">Edit</button>
      </div>
      <div class="profile-item">
        <button class="btn btn-primary edit-button">Edit Password</button>
      </div>
    </div>
</div>








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
