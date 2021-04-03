
<?php  include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FreeTime • Sign Up</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/Signup.css">
    <link rel="icon" href="imgs/FreeTimelogo.png">
</head>
 <script>
     $(document).ready(function(){

     })
 </script>
<body>
   
   <div class="all">
     <div class="logo_container">
       <img src="imgs/FreeTimelogo.png" alt="Logo" class="animate__animated ">
    <p>What is Freetime?</p>
    <p></p>
     </div>
    <div class="form_container animate__animated ">
       <p class="signup_text">Sign Up</p>
        <form action="registration.php" method="POST" class="reg_form">
          
            <input class="reg_username input" type="text" placeholder="username" name="username" autocomplete="off"><br>
            <input type="email" class="reg_email input" placeholder="email" name="email" autocomplete="off"><br>
            <input type="password" class="reg_password input" placeholder="password" name="password" autocomplete="off"><br>
            <input type="password" class="reg_confirm input" placeholder="Confirm Password" name="confirm" autocomplete="off">
       <p>Already a user?<a href="login.php"><b>Sign In</b></a></p>
            <input type="submit"  class="reg_btn" value="Sign Up" name="reg_btn">
            <?php include('errors.php'); ?>
        </form>

</div>
    </div>
</body>
</html>
<?php 
  if(isset($_SESSION['username'])){
      header('location: main.php');
 }
?>