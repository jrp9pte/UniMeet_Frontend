<!--This stores the e-mail used to log-in (so we can query with the given e-mail) -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
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
  <!-- NavBar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">UniMeet</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="#">
          <div class="icon-wrapper">
              <i class="mdi mdi-home icon"></i>
          </div>
          <div class="text-wrapper">
              Home
          </div>
        </a>
        <a class="nav-item nav-link active" href="#">
          <div class="icon-wrapper">
              <i class="mdi mdi-calendar icon"></i>
          </div>
          <div class="text-wrapper">
              Events
          </div>
        </a>
        <a class="nav-item nav-link active" href="#">
          <div class="icon-wrapper">
              <i class="mdi mdi-account-group icon"></i>
          </div>
          <div class="text-wrapper">
              Clubs
          </div>
        </a>
        <a class="nav-item nav-link active" href="#">
          <div class="icon-wrapper">
              <i class="mdi mdi-account icon"></i>
          </div>
          <div class="text-wrapper">
              Account
          </div>
        </a>
        <a class="nav-item nav-link active" href="login.php">
          <div class="icon-wrapper">
              <i class="mdi mdi-logout icon"></i>
          </div>
          <div class="text-wrapper">
              Log Out
          </div>
        </a>
      </div>
    </div>
  </nav>

<div class="row justify-content-center mt-4">
  <div class="col">
    <h3 class="row justify-content-center">My Events</h3>
    <div class="card">
      <div class="row">
        <div class="col">
          <h4 class="card-title event-name">Event Name</h4>
          <h6 class="card-subtitle mb-2">Location</h6>
          <h6 class="card-subtitle mb-2">Club</h6>
        </div>
        <div class="col text-end card-right-col">
          <h3 class="card-time card-title text-right">7:00</h3>
          <h6 class="card-subtitle mb-2 text-right">4/5/24</h6>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <h3 class="row justify-content-center">My Clubs</h3>
    <div class="card">
      <div class="row">
        <div class="col">
          <h4 class="card-title event-name">Club Name</h4>
          <h6 class="card-subtitle mb-2">Club Category</h6>
        </div>
        <div class="col text-end card-right-col">
          <h3 class="card-time card-title text-right">PRIV</h3>
        </div>
      </div>
    </div>
  </div>
</div>


<br/><br/>

 

<!-- <script src='maintenance-system.js'></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>