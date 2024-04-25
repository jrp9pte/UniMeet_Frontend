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
  //var_dump($list_of_categories);
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
  <meta name="description" content="Maintenance request form, a small/toy web app for ISP homework assignment, used by CS 3250 (Software Testing)">
  <meta name="keywords" content="CS 3250, Upsorn, Praphamontripong, Software Testing">
  <link rel="icon" href="https://www.cs.virginia.edu/~up3f/cs3250/images/st-icon.png" type="image/png" />  
  
  <title>UniMeet</title>
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="../unimeet.css">  
</head>

<body>  
<?php include('../navbar.html') ?> 
<div class="row justify-content-center mt-4">
  <div class="col">
    <div class="d-flex justify-content-center align-items-center">
      <h3 class="mr-3">Create Club</h3>
    </div>
    <form class="search-bar" action="./create-club-process.php" method="post">
        <div class="form-group mb-3">
            <label for="club-name">Club Name:</label>
            <input type="text" class="mt-2 form-control" id="club-name" name="club-name" aria-describedby="clubHelp" placeholder="Enter club name...">
        </div>
        <div class="form-group mb-3">
            <label for="club-category">Select Club Category:</label>
            <select class="mt-2 form-control" id="club-category" name="club-category">
            <?php foreach ($list_of_categories as $category_info): ?>
                <option value="<?php echo $category_info['category_name']; ?>"><?php echo $category_info['category_name']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="create-club-button" value="Create" class="btn btn-primary">Create Club</button>
    </form>
  </div>
</div>




<br/><br/>

 

<!-- <script src='maintenance-system.js'></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>