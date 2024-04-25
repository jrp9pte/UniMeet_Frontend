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
  <link rel="stylesheet" href="unimeet.css">  
</head>

<body>  
  <?php include('navbar.html') ?> 
  <div class="row justify-content-center mt-4">
    <div class="col">
      <h3 class="row justify-content-center">My Events</h3>
      <?php foreach ($list_of_events as $event_info): ?>
      <div class="card">
        <div class="row">
          <div class="col">
            <h4 class="card-title event-name"><?php echo $event_info['event_description']?></h4>
            <h6 class="card-subtitle mb-2"><?php echo $event_info['address']?></h6>
            <h6 class="card-subtitle mb-2"><?php echo $event_info['club_description']?></h6>
            <h6 class="card-subtitle mb-2"><?php echo $event_info['category_name']?></h6>
          </div>
          <div class="col text-end card-right-col">
            <h3 class="card-time card-title text-right"><?php echo date("d-m-Y", strtotime($event_info['date']))?></h3>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="col">
      <h3 class="row justify-content-center">My Clubs</h3>
      <?php foreach ($list_of_clubs as $club_info): ?>
      <div class="card">
        <div class="row">
          <div class="col">
            <h4 class="card-title event-name"><?php echo $club_info['club_description']?></h4>
            <h6 class="card-subtitle mb-2"><?php echo $club_info['category_name']?></h6>
          </div>
          <div class="col text-end card-right-col">
            <h3 class="card-time card-title text-right"><?php echo strtoupper($club_info['privilege'])?></h3>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>


  <br/><br/>

 

<!-- <script src='maintenance-system.js'></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>