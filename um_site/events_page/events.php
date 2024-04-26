<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
//   var_dump($username);
  $list_of_events = getAllEvents();
  // console log the list of events
  // var_dump($list_of_events);
  $list_of_user_event_ids = getEventsByAccount($username);
  $list_of_my_events = getAllEventsUserIsAdminOf($username);
//   var_dump($list_of_user_event_ids);
//   $json = json_encode($list_of_user_event_ids, JSON_PRETTY_PRINT);
//             echo "<script>
//             console.log( $json);
//             </script>";
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: ../login_page/login.php");
  exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!empty($_POST['search-button'])){
    $list_of_events = getEventsByFilter($_POST['search-filter']);
  }
  else if(!empty($_POST['leave-button'])){
    // deleteMember($_POST['club_id'], $username);
    // $list_of_user_club_ids = getEventsByAccount($username);
    $result = deleteReservation($username, $_POST['event_id'] );
    header("Location: ./events.php");
  }
  else if(!empty($_POST['join-button'])){
    // if user wants to join event
    // $result = createMember($_POST['event_id'], $username, 'user');
    $result = createReservation($_POST['event_id'], $username);
    // var_dump("create reservation" , $result);
    $list_of_user_event_ids = getEventsByAccount($username);
    // var_dump("list_of_user_event_ids", $result);
    header("Location: ./events.php");
    
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
                <h3 class="mr-3">Events</h3>
                <a class="nav-item nav-link active" href="create-event.php">
                    <div class="icon-wrapper">
                        <i class="mdi mdi-plus add-icon"></i>
                    </div>
                </a>
            </div>
            <form action="events.php" method="post" class="search-bar">
                <div class="input-group mb-3">
                    <input type="text" name="search-filter" class="form-control" placeholder="Search Events..."
                        aria-label="Search Events..." aria-describedby="button-addon2"
                        value="<?php echo isset($_POST['search-filter']) ? $_POST['search-filter'] : ''; ?>">
                    <div class="input-group-append">
                        <button class="btn search-button" type="submit" name="search-button" value="Search"
                            id="button-addon2"><i class="mdi mdi-magnify search-icon"></i></button>
                        <?php if (!empty($_POST['search-filter'])): ?>
                        <button class="btn clear-button" type="button" onclick="location.href='events.php'"><i
                                class="mdi mdi-close-circle-outline clear-icon"></i></button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
            <!-- Reset button -->
            <!--Cards  -->
            <?php if (empty($list_of_events)): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">No Events</h5>
                    <p class="card-text">There are currently no events available for selected options</p>
                </div>
            </div>
            <?php endif; ?>
            <?php foreach ($list_of_events as $event_info): ?>
            <!-- <?php $json = json_encode((($event_info)), JSON_PRETTY_PRINT);
            echo "<script>
            console.log($json);
            </script>"; ?> -->
            <div class="card mb-3">
                <div class="">
                    <div style="display: grid; grid-template-columns: 30% auto auto;  margin: auto;">
                        <div style="margin: auto;">
                            <h4 style="max-width: fit-content; justify-content: flex-start; " class=" card-title">
                                <?php echo $event_info['event_description']; ?></h4>
                            <p class="card-text"><?php echo $event_info['address']; ?></p>
                            <p class="card-text"><?php echo getClubByID($event_info['club_id'])[1]; ?></p>
                            <p class="card-text">Category:
                                <?php echo getClubByID($event_info['club_id'])[2]; ?></p>
                        </div>

                        <div style="max-width: fit-content; margin: auto; text-align: left ">
                            <p class="card-text"><?php echo $event_info['date']; ?></p>
                        </div>

                        <div style="max-width: fit-content;  text-align: right; padding: auto; margin: auto;">

                            <p style="max-width: fit-content; margin-left: auto; margin-right: auto;" class="card-text">
                                <span
                                    style="color: <?php echo (getEventCurrentCapacity($event_info['event_id']) == $event_info['capacity']) ? 'red' : ''; ?>"
                                    class="spots-remaining"><?php echo getEventCurrentCapacity($event_info['event_id']); ?></span>/<?php echo ($event_info['capacity']); ?>
                                Spots Filled
                            </p>

                            <?php if (in_array($event_info['event_id'], $list_of_user_event_ids)): ?>
                            <form style="max-width: fit-content; margin-left: auto; margin-right: auto;"
                                action="events.php" method="post">
                                <button type="submit" name="leave-button" value="Leave"
                                    class="btn btn-danger d-block mb-2">Leave Event</button>
                                <input type="hidden" name="event_id" value="<?php echo $event_info['event_id']; ?>" />
                            </form>
                            <?php else: ?>
                            <form style="max-width: fit-content; margin-left: auto; margin-right: auto;"
                                action="events.php" method="post">
                                <button type="submit" name="join-button" value="Join"
                                    class="btn btn-success d-block mb-2">Join Event</button>
                                <input type="hidden" name="event_id" value="<?php echo $event_info['event_id']; ?>" />
                            </form>
                            <?php endif; ?>
                            <a style="max-width: fit-content; margin-left: auto; margin-right: auto;"
                                href="event-details.php?event_id=<?php echo $event_info['event_id'] ?>"
                                class="btn btn-warning d-block">View Details...</a>
                            <!--Uncomment for real version,need this for now to be able to access  -->
                            <!-- <?php if (in_array($event_info['event_id'], $list_of_my_events)): ?> -->
                            <a style="max-width: fit-content; margin-left: auto; margin-right: auto;"
                                href="event-details.php?event_id=<?php echo $event_info['event_id'] ?>"
                                class="btn btn-warning d-block">View Details...</a>
                            <!-- <?php endif; ?> -->
                        </div>
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