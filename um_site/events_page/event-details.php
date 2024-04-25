<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: ../login_page/login.php");
  exit();
}
if(isset($_GET['club_id'])) {
    $club_id = $_GET['club_id'];
    $club = getClubByID($club_id);
    $club_events = getEventsByClub($club_id);
    $club_members = getMembersByClub($club_id);
    $privilege = 'user';
    foreach ($club_members as $item){
      if($item['email'] === $username){
        $privilege = $item['privilege'];
        break;
      }
    }
    //var_dump($club_members);
} else {
    echo "Club ID not provided.";
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!empty($_POST['remove-button'])){
    if($_POST['email'] === $username){
      echo '<script>alert("Error: Unable to delete yourself as a member.")</script>'; 
    }
    else{
      deleteMember($club_id, $_POST['email']);
      $club_members = getMembersByClub($club_id);
    }
  }
  else if(!empty($_POST['demote-button'])){
    if($_POST['email'] === $username){
      echo '<script>alert("Error: Unable to edit your own role as a member.")</script>'; 
    }
    else{
      updateMember($club_id, $_POST['email'], 'user');
      $club_members = getMembersByClub($club_id);
    }
  }
  else if(!empty($_POST['promote-button'])){
    if($_POST['email'] === $username){
      echo '<script>alert("Error: Unable to edit your own role as a member.")</script>'; 
    }
    else{
      updateMember($club_id, $_POST['email'], 'admin');
      $club_members = getMembersByClub($club_id);
    }
  }
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
<div class="mt-4">
    <h3 class="row justify-content-center"><?php echo $club['club_description']?></h3>
    <h4 class="row justify-content-center details-club"><?php echo $club['category_name']?></h4>
</div>
<div class="row justify-content-center mt-4">
  <div class="col">
    <div class="d-flex justify-content-center align-items-center">
      <h3 class="mr-3">Club Events</h3>
      <a class="nav-item nav-link active" href="../events_page/create-event.php">
        <div class="icon-wrapper">
          <i class="mdi mdi-plus add-icon"></i>
        </div>
      </a>
    </div>
    <?php foreach ($club_events as $event_info): ?>
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
    <div class="d-flex justify-content-center align-items-center">
      <h3 class="mr-3">Club Members</h3>
      <a class="nav-item nav-link active" href="create-member.php?club_id=<?php echo $club_id; ?>">
        <div class="icon-wrapper">
          <i class="mdi mdi-plus add-icon"></i>
        </div>
      </a>
    </div>
    <?php foreach ($club_members as $member_info): ?>
      <div class="card">
        <div class="card-body d-flex justify-content-between">
          <div>
            <h4 class="card-title event-name"><?php echo $member_info['email']?></h4>
          </div>
          <div>
            <h3 class="card-time card-title text-right"><?php echo strtoupper($member_info['privilege'])?></h3>
            <?php if ($privilege === 'admin'): ?>
              <form action="club-details.php?club_id=<?php echo $club_id ?>" method="post">
                <?php if ($member_info['privilege'] === 'admin'): ?>
                <button type="submit" name="demote-button" value="Role Change" class="btn btn-warning d-block mb-2">Demote Member</button>
                <?php elseif ($member_info['privilege'] === 'user'): ?>
                <button type="submit" name="promote-button" value="Role Change" class="btn btn-warning d-block mb-2">Promote Member</button>
                <?php endif; ?>
                <input type="hidden" name="email" value="<?php echo $member_info['email']; ?>" />
              </form>
              <form action="club-details.php?club_id=<?php echo $club_id ?>" method="post">
                <button type="submit" name="remove-button" value="Remove" class="btn btn-danger d-block mb-2">Remove Member</button>
                <input type="hidden" name="email" value="<?php echo $member_info['email']; ?>" />
              </form>
            <?php endif; ?>
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