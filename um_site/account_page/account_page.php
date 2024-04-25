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
  
  <div class="container">
  <h1 class="text-center mt-4">Profile</h1>
  <div class="row mt-5 justify-content-center">

    <div class="col-md-6 mb-4">
      <div class="rounded bg-light p-3 d-flex justify-content-between align-items-center">
        <h4>Email: <?php echo $email; ?></h4>
        <button class="btn btn-primary">Edit</button>
      </div>
    </div>

    <div class="w-100"></div> <!-- Add a new row -->

    <div class="col-md-6 mb-4">
      <div class="rounded bg-light p-3 d-flex justify-content-between align-items-center">
        <h4>Password: <span class="password-censored"><?php echo $censored; ?></span></h4>
        <button class="btn btn-primary">Edit</button>
      </div>
    </div>
    
    <div class="w-100"></div> <!-- Add a new row -->

    <div class="col-md-6 mb-4">
      <div class="rounded bg-light p-3 d-flex justify-content-between align-items-center">
        <h4>First Name: <?php echo $first_name; ?></h4>
        <button class="btn btn-primary">Edit</button>
      </div>
    </div>

    <div class="w-100"></div> <!-- Add a new row -->

    <div class="col-md-6 mb-4">
      <div class="rounded bg-light p-3 d-flex justify-content-between align-items-center">
        <h4>Last Name: <?php echo $last_name; ?></h4>
        <button class="btn btn-primary">Edit</button>
      </div>
    </div>
    
  </div>
</div>









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
