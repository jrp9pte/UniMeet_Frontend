<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['create-event-button'])){
        var_dump("reached here");
        
        $eventID = createEvent( $_POST['event-location'], $_POST['event-date'], $_POST['event-name'],  $_POST['event-category'],$username ,$_POST['event-club']);
        var_dump("reached here2");
        header("Location: ./events.php");
        var_dump("reached here3");
        exit();
    }
  }
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: login.php");
  exit();
}
?>