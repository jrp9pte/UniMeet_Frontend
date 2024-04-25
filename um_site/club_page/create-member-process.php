<?php
require("connect-db.php");
require("unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
    if(isset($_GET['club_id'])) {
        $club_id = $_GET['club_id'];
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!empty($_POST['create-member-button'])){
                createMember($club_id, $_POST['member-email'], $_POST['member-privilege']);
                header("Location: club-details.php?club_id=" . $club_id);
                exit();
            }
        }
    } else {
        echo "Club ID not provided.";
        header("Location: clubs.php");
        exit();
    }
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: login.php");
  exit();
}
?>