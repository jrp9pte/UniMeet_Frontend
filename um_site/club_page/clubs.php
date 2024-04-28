<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
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
  header("Location: ../login_page/login.php");
  exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!empty($_POST['search-button'])){
    $list_of_clubs = getClubsByFilter($_POST['search-filter']);
  }
  else if(!empty($_POST['leave-button'])){
    $members = getMembersByClub($_POST['club_id']);
    $emails = array();
    foreach($members as $item){
        if($item['privilege'] === 'admin'){
            $emails[] = $item['email'];
        }
    }
    if(count($emails) === 1){
        echo '<script>alert("Error: Can not leave the club as you are the last remaining admin.")</script>'; 
    }
    else{
        deleteMember($_POST['club_id'], $username);
        $list_of_user_club_ids = getClubIDsByAccount($username);
    }
  }
  else if(!empty($_POST['join-button'])){
    $result = createMember($_POST['club_id'], $username, 'user');
    var_dump($result);
    $list_of_user_club_ids = getClubIDsByAccount($username);
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
    <meta name="description"
        content="Maintenance request form, a small/toy web app for ISP homework assignment, used by CS 3250 (Software Testing)">
    <meta name="keywords" content="CS 3250, Upsorn, Praphamontripong, Software Testing">
    <link rel="icon" href="https://www.cs.virginia.edu/~up3f/cs3250/images/st-icon.png" type="image/png" />

    <title>UniMeet</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../unimeet.css">
</head>

<body>
    <?php include('../navbar.html') ?>
    <div class="row justify-content-center mt-4">
        <div class="col">
            <div class="d-flex justify-content-center align-items-center">
                <h3 class="mr-3">Clubs</h3>
                <a class="nav-item nav-link active" href="create-club.php">
                    <div class="icon-wrapper">
                        <i class="mdi mdi-plus add-icon"></i>
                    </div>
                </a>
            </div>
            <form action="clubs.php" method="post" class="search-bar">
                <div class="input-group mb-3">
                    <input type="text" name="search-filter" class="form-control" placeholder="Search Clubs..."
                        aria-label="Search Clubs..." aria-describedby="button-addon2"
                        value="<?php echo isset($_POST['search-filter']) ? $_POST['search-filter'] : ''; ?>">
                    <div class="input-group-append">
                        <button class="btn search-button" type="submit" name="search-button" value="Search"
                            id="button-addon2"><i class="mdi mdi-magnify search-icon"></i></button>
                        <?php if (!empty($_POST['search-filter'])): ?>
                        <button class="btn clear-button" type="button" onclick="location.href='clubs.php'"><i
                                class="mdi mdi-close-circle-outline clear-icon"></i></button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
            <?php if (empty($list_of_clubs)): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">No Clubs</h5>
                    <p class="card-text">There are currently no clubs available for selected options</p>
                </div>
            </div>
            <?php endif; ?>
            <?php foreach ($list_of_clubs as $club_info): ?>
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4 class="card-title event-name"><?php echo $club_info['club_description']?></h4>
                        <h6 class="card-subtitle mb-2"><?php echo $club_info['category_name']?></h6>
                    </div>
                    <div>
                        <?php if (in_array($club_info['club_id'], $list_of_user_club_ids)): ?>
                        <form action="clubs.php" method="post">
                            <button type="submit" name="leave-button" value="Leave"
                                class="btn btn-danger d-block mb-2">Leave Club</button>
                            <input type="hidden" name="club_id" value="<?php echo $club_info['club_id']; ?>" />
                        </form>
                        <?php else: ?>
                        <form action="clubs.php" method="post">
                            <button type="submit" name="join-button" value="Join"
                                class="btn btn-success d-block mb-2">Join Club</button>
                            <input type="hidden" name="club_id" value="<?php echo $club_info['club_id']; ?>" />
                        </form>
                        <?php endif; ?>
                        <a href="club-details.php?club_id=<?php echo $club_info['club_id'] ?>"
                            class="btn btn-warning d-block">View Details...</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>




    <br /><br />



    <!-- <script src='maintenance-system.js'></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>