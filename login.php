<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
  <div class="log_div">
  <form action="login.php" method="post" class="log_form">
    <h1 class="log_text">Sign In</h1>
    <input type="text" placeholder="Username" name="logUsername" class="log_username" autocomplete="off"><br>
    <input type="password" placeholder="Password" name="logPassword" class="log_password" autocomplete="off">
    <h5>Not a user?<a href="registration.php" class="log_btn"><b>Sign Up</b></a></h5>
    <input type="submit" value="Sign In" name="log_btn">
    <?php include('logErrors.php'); ?>
  </form>
</div>
</body>
</html>
<?php 
  if(isset($_SESSION['username'])){
      header('location: main.php');
 }
?>