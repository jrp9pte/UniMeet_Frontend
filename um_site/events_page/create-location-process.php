<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['create-location-button'])){
        $locationID = createLocation($_POST['capacity'], $_POST['location'] );
        header("Location: ./create-event.php");
        exit();
    }
  }
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: login.php");
  exit();
}
?>