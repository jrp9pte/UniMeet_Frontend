<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>

<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
    if(isset($_GET['club_id'])) {
        $club_id = $_GET['club_id'];
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!empty($_POST['create-member-button'])){
                $account = getAccount($_POST['member-email']);
                if($account){
                    $members = getMembersByClub($club_id);
                    $emails = array();
                    foreach($members as $item){
                        $emails[] = $item['email'];
                    }
                    if(in_array($_POST['member-email'], $emails)){
                        echo '<script>alert("Email is already a member of the club.")</script>'; 
                        echo '<script>window.location.href = "./create-member.php?club_id=' . $club_id . '";</script>';
                    }
                    else{
                        createMember($club_id, $_POST['member-email'], $_POST['member-privilege']);
                        header("Location: ./club-details.php?club_id=" . $club_id);
                        exit();
                    }
                    //var_dump($emails);
                    //var_dump(in_array("ajp4hrw@virginia.edu", $emails));
                }
                else{
                    echo '<script>alert("No account with that e-mail exists.")</script>'; 
                    echo '<script>window.location.href = "./create-member.php?club_id=' . $club_id . '";</script>';
                }
            }
        }
    } else {
        echo "Club ID not provided.";
        header("Location: ./clubs.php");
        exit();
    }
} else {
  // Redirect to login page or handle unauthorized access
  header("Location: ../login_page/login.php");
  exit();
}
?>