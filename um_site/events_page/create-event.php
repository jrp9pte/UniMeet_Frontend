<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  //var_dump($username);
  $list_of_categories = getCategories();
  $list_of_locations = getAllLocations();
  $list_of_clubs = getClubs();
  // sort list of locations by 'address' alphabetically
  usort($list_of_locations, function($a, $b) {
    return $a['address'] <=> $b['address'];
  });
  // console log the list of events
//   $json = json_encode($list_of_clubs, JSON_PRETTY_PRINT);
//     echo "<script>
//             console.log( $json);
//             </script>";
//   var_dump($list_of_categories);
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
                <h3 class="mr-3">Create Event</h3>
            </div>
            <form class="search-bar" action="create-event-process.php" method="post">
                <div class="form-group mb-3">
                    <label for="event-name">Event Name:</label>
                    <input type="text" class="mt-2 form-control" id="event-name" name="event-name" required
                        aria-describedby="eventHelp" placeholder="Enter event name...">
                </div>
                <div class="form-group mb-3">
                    <label for="date">Enter a date:</label>
                    <input type="date" class="mt-2 form-control" id="event-date" name="event-date" required>
                </div>
                <div class="form-group mb-3">
                    <label>Select Event Category:</label>
                    <select class="mt-2 form-control" id="event-category" name="event-category">
                        <?php foreach ($list_of_categories as $category_info): ?>
                        <option value="<?php echo $category_info['category_name']; ?>">
                            <?php echo $category_info['category_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Select location:</label>
                    <select class="mt-2 form-control" id="event-location" name="event-location">
                        <?php foreach ($list_of_locations as $location_info): ?>
                        <option value="<?php echo $location_info; ?>">
                            <?php echo getLocation($location_info)[2]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Select Club:</label>
                    <select class="mt-2 form-control" id="event-club" name="event-club">
                        <?php foreach ($list_of_clubs as $club_info): ?>
                        <option value="<?php echo $club_info['club_id']; ?>">
                            <?php echo $club_info['club_description']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="create-event-button" value="Create" class="btn btn-primary">Create
                    Event</button>
            </form>
            <div class="d-flex justify-content-center align-items-center">
                <h3 class="mr-3">Create Location</h3>
            </div>
            <form class="search-bar" action="create-location-process.php" method="post">
                <div class="form-group mb-3">
                    <label for="location-name">Location address:</label>
                    <input type="text" class="mt-2 form-control" id="location" name="location" required
                        aria-describedby="locationHelp" placeholder="Enter location address">
                </div>
                <div class="form-group mb-3">
                    <label for="location-name">Capacity:</label>
                    <input type="number" min="1" class="mt-2 form-control" id="capacity" name="capacity" required
                        aria-describedby="locationHelp" placeholder="Enter capacity">
                </div>

                <button type="submit" name="create-location-button" value="Create Location"
                    class="btn btn-primary">Create
                    Location</button>
            </form>
        </div>
    </div>




    <br /><br />



    <!-- <script src='maintenance-system.js'></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>