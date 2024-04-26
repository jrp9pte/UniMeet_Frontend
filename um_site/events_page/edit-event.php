<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>


<?php
session_start();
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  } else {
    header("Location: ../login_page/login.php");
    exit();
  }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $description = $_POST['event_description'];
    $address = $_POST['address'];
    $date = $_POST['date'];


    $query = "UPDATE events SET event_description = ?, address = ?, date = ? WHERE event_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$description, $address, $date, $event_id]);

    header("Location: ../events_page/event-details.php?event_id=<?php $event_id>"); 
    exit();
}
?>
