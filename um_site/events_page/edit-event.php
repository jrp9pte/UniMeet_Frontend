<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>

<?php

session_start();


if (isset($_SESSION['username'])) {
  // echo '<pre>';
  // var_dump("1");
  // echo '</pre>';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $event_id = $_POST['event_id'] ?? null;
      $event_description = $_POST['event_description'] ?? null;
      $date = $_POST['date'] ?? null;
      $address = $_POST['address'] ?? null;
      $capacity = $_POST['capacity'] ?? null;

      // echo '<pre>';
      // var_dump("1");
      // echo '</pre>';
  
      if (empty($event_description) || empty($address) || empty($date) || empty($capacity)) {
          header("Location: ../events_page/event-details.php?event_id={$event_id}&error=blankFields");
          exit();
      }
    
     if (updateEventDetails($event_id, $event_description, $date, $address, $capacity)) {
        header("Location: ../events_page/event-details.php?event_id=$event_id&success=updateSuccessful");
     } else {
        header("Location: ../events_page/event-details.php?event_id=$event_id&error=eventUpdateFailed");
      }
    }
} else {
    header("Location: ../login_page/login.php");
    exit();
}
?>

