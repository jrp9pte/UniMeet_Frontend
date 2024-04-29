<?php
require("../database/connect-db.php");
require("../database/unimeet-db.php");
?>
<?php
session_start();
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
    //var_dump($username);
  $list_of_events = getEventsByAccount($username);
  $list_of_clubs = getClubsByAccount($username);
  //var_dump($list_of_events);

  // Get user information
  $user_info = getAccount($username);
  $first_name = $user_info['first_name'];
  $last_name = $user_info['last_name'];
  $email = $user_info['email'];
  $password = $user_info['password'];
  

} else {
  // Redirect to login page or handle unauthorized access
  header("Location: ../login_page/login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the updated values from the form
  //var_dump($password);
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
 

  // Update the user information in the database
  updateAccount($email, $first_name, $last_name);


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

  <style>
    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 60vh; /* This will center the container vertically */
    }

    .profile-item {
      margin-bottom: 1.5em; /* This will add more vertical space between the lines */
    }

    input[readonly] {
      background-color: #f0f0f0;
      margin-right: 1em; /* This will add more horizontal space between the text boxes and the edit buttons */
    }

    .btn {
      width: 200px; /* This will make the buttons as large as the text boxes */
    }
  </style>
</head>


<body>  
  <?php include('../navbar.html') ?> 
  <div class="row justify-content-center mt-4">
    <div class="col">
      <div class="d-flex justify-content-center align-items-center">
          <h3 class="mr-3">Profile</h3>
      </div>
      <form class="search-bar" method="post">
        <label for="first_name">First Name:</label>
        <div class="form-group mb-3 d-flex align-items-center">
          <input type="text" class="mt-2 form-control" name="first_name" value="<?php echo $first_name; ?>" readonly>
          <button type="button" class="btn btn-primary edit-button ml-2">Edit</button>
        </div>
        <label for="last_name">Last Name:</label>
        <div class="form-group mb-3 d-flex align-items-center">
          <input type="text" class="mt-2 form-control" name="last_name" value="<?php echo $last_name; ?>" readonly> 
          <button type="button" class="btn btn-primary edit-button ml-2">Edit</button>
        </div>
        <label for="password">Password:</label>
        <div class="form-group mb-3 d-flex align-items-center">
          <input type="password" class="mt-2 form-control" name="password" id="password" value="------" readonly> 
          <button type="button" class="btn btn-primary ml-2" id="change-password" onclick="window.location.href='change_password.php'">Change Password</button>
        </div>
        <label for="email">E-mail:</label>
        <div class="form-group mb-3 d-flex align-items-center">
          <input type="text" class="mt-2 form-control" name="email" value="<?php echo $email; ?>" readonly> 
        </div>
        <div class="form-group mb-3 d-flex align-items-center">
          <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</body>






<script>
    window.onload = function() {
  var editButtons = document.getElementsByClassName('edit-button');
  for (var i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function() {
      var input = this.previousElementSibling;
      if (this.textContent === 'Edit') {
        input.dataset.oldValue = input.value;
        input.readOnly = false;
        input.focus();
        this.textContent = 'Cancel'; 
      } else {
        input.value = input.dataset.oldValue;
        input.readOnly = true;
        this.textContent = 'Edit'; 
      }
    });
  }
}

</script>

<script>
document.getElementById('change-password').addEventListener('click', function() {
  document.getElementById('passwordChangeForm').style.display = 'block';
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
