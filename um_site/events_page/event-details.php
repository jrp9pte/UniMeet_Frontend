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
if(isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $club = getClubByID($club_id);
    $club_events = getEventsByClub($club_id);
    $event_members = getMembersByClub($club_id);
    $event_details = getEventDetails($event_id);
    $reservations = getReservationsForEvent($event_id);
    echo '<pre>';
    print_r($event_details);
    echo '</pre>';
    $privilege = 'user';
    foreach ($club_members as $item){
      if($item['email'] === $username){
        $privilege = $item['privilege'];
        break;
      }
    }
    //var_dump($club_members);
} else {
    echo "Event ID not provided.";
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
    <div class="mt-4">
      <h3 class="text-center"><?php echo $event_details['event_description']; ?></h3>
      <div class="row justify-content-center align-items-center">
        <div class="col-auto text-center">
            <h4 class="d-inline"><?php echo $event_details['club_description']; ?></h4>
        </div>
        <div class="col-auto">
            <a href="../club_page/club-details.php?club_id=<?php $event_details['club_id']; ?>">
                <i class="mdi mdi-information-outline" style="font-size: 24px;"></i>
            </a>
        </div>
      </div>
    </div>
</div>
    <div class="row justify-content-center mt-4">
        <div class="col">
          <div class="d-flex justify-content-center align-items-center">
              <h3 class="mr-3">Event Details</h3>
          </div>
          <div class="card mb-3">
              <form action="edit_event.php" method="post">
                  <div class="row">
                      <div class="col-md-8">
                          <input type="text" class="form-control mb-2" name="event_description" value="<?php echo$event_details['event_description']; ?>">
                          <input type="text" class="form-control mb-2" name="address" value="<?php echo $event_details['address']; ?>">
                          <input type="date" class="form-control mb-2" name="date" value="<?php echo $event_details['date']; ?>">
                          <div class="mb-2">
                            <label class="form-label">Club Description: <?php echo htmlspecialchars($event_details['club_description']); ?></label>
                          </div>
                          <div class="mb-2">
                            <label class="form-label">Category Name: <?php echo htmlspecialchars($event_details['category_name']); ?></label>
                          </div>
                      </div>
                      <div class="col-md-4 text-end">
                          <button type="submit" class="btn btn-primary mb-2">Save Changes</button>
                      </div>
                  </div>
                  <input type="hidden" name="event_id" value="<?php echo $event_info['event_id']; ?>">
              </form>
          </div>
        </div>
        <div class="col">
            <div class="d-flex justify-content-center align-items-center">
                <h3 class="mr-3">Members</h3>
            </div>
            <?php foreach ($members as $member_info): ?>
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4 class="card-title event-name"><?php echo $member_info['email']?></h4>
                    </div>
                    <div>
                        <h3 class="card-time card-title text-right"><?php echo strtoupper($member_info['privilege'])?>
                        </h3>
                        <?php if ($privilege === 'admin'): ?>
                        <form action="club-details.php?club_id=<?php echo $club_id ?>" method="post">
                            <?php if ($member_info['privilege'] === 'admin'): ?>
                            <button type="submit" name="demote-button" value="Role Change"
                                class="btn btn-warning d-block mb-2">Demote Member</button>
                            <?php elseif ($member_info['privilege'] === 'user'): ?>
                            <button type="submit" name="promote-button" value="Role Change"
                                class="btn btn-warning d-block mb-2">Promote Member</button>
                            <?php endif; ?>
                            <input type="hidden" name="email" value="<?php echo $member_info['email']; ?>" />
                        </form>
                        <form action="club-details.php?club_id=<?php echo $club_id ?>" method="post">
                            <button type="submit" name="remove-button" value="Remove"
                                class="btn btn-danger d-block mb-2">Remove Member</button>
                            <input type="hidden" name="email" value="<?php echo $member_info['email']; ?>" />
                        </form>
                        <?php endif; ?>
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