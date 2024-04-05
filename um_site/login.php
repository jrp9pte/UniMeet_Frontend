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
  <link rel="stylesheet" href="unimeet.css">  
</head>

<body>  
<h1 class="row justify-content-center mt-4 login-title">UniMeet</h1>
<div class="row justify-content-center mt-4">
  <div class="login-col col">
    <i class="mdi mdi-account-plus-outline icon login-icon"></i>
    <h3 class="row justify-content-center">Sign Up</h3>
    <div class="form-container">
        <form>
            <div class="form-group">
                <label for="username">E-Mail<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary login-button">Sign Up</button>
        </form>
    </div>
  </div>
  <div class="login-col col">
    <i class="mdi mdi-account-check-outline icon login-icon"></i>
    <h3 class="row justify-content-center">Sign In</h3>
    <div class="form-container">
        <form action="homepage.php" method="post">
            <div class="form-group">
                <label for="username">E-Mail<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary login-button">Login</button>
        </form>
    </div>
  </div>
</div>


<br/><br/>

 

<!-- <script src='maintenance-system.js'></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>