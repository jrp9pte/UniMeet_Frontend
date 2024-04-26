<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");

session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    // Check if the new password is the same as the old one
    if (empty($oldPassword) || empty($newPassword)) {
      $message = "Both old and new passwords must be provided!";
    } else {
      // Get the current password from the database
      $user_info = getAccount($username);
      $first_name = $user_info['first_name'];
      $last_name = $user_info['last_name'];
      $email = $user_info['email'];
      $currentPassword = $user_info['password'];

      // Verify the old password
      if (password_verify($oldPassword, $currentPassword)) {
        // Check if either oldPassword or newPassword are empty
        if ($oldPassword === $newPassword) {
          $message = "New password must be different from the old password!";
        }  else { 
          updateAccount($email, $newPassword, $first_name, $last_name);
          $message = "Password changed successfully!";
        } 
      } else {
        $message = "Incorrect old password!";
      }
    }
  }
} else {
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
  <meta name="description" content="Maintenance request form, a small/toy web app for ISP homework assignment, used by CS 3250 (Software Testing)">
  <meta name="keywords" content="CS 3250, Upsorn, Praphamontripong, Software Testing">
  <link rel="icon" href="https://www.cs.virginia.edu/~up3f/cs3250/images/st-icon.png" type="image/png" />  
  
  <title>UniMeet</title>
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="../unimeet.css">
  <title>Change Password</title>
</head>

<body>
<?php include('../navbar.html') ?> 
  <h1>Change Password</h1>
  <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
  <form method="post">
    <label for="oldPassword">Old Password:</label>
    <input type="password" id="oldPassword" name="oldPassword">
    <label for="newPassword">New Password:</label>
    <input type="password" id="newPassword" name="newPassword">
    <input type="submit" value="Change Password">
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
