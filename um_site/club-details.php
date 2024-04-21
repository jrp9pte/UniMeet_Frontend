<?php
require("connect-db.php");
require("unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  //var_dump($username);
  $list_of_clubs = getClubs();
  $list_of_user_club_ids = getClubIDsByAccount($username);
  //var_dump($list_of_user_club_ids);
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: login.php");
  exit();
}
if(isset($_GET['club_id'])) {
    $club_id = $_GET['club_id'];
    $club = getClubByID($club_id);
    //var_dump($club);
} else {
    echo "Club ID not provided.";
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
  <link rel="stylesheet" href="unimeet.css">  
</head>

<body>  
<?php include('navbar.html') ?> 
<div class="mt-4">
    <h3 class="row justify-content-center"><?php echo $club['club_description']?></h3>
    <h4 class="row justify-content-center details-club"><?php echo $club['category_name']?></h4>
</div>
<div class="row justify-content-center mt-4">
  <div class="col">
    <h3 class="row justify-content-center">Club Events</h3>
  </div>
  <div class="col">
    <h3 class="row justify-content-center">Club Members</h3>
  </div>
</div>




<br/><br/>

 

<!-- <script src='maintenance-system.js'></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>