<?php
session_start();

  $errors = array();
  $logErrors = array();
  $db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");
  
  if(isset($_POST['reg_btn'])){
  $username = mysqli_real_escape_string($db,$_POST['username']);
  $email = mysqli_real_escape_string($db,$_POST['email']);
  $password = mysqli_real_escape_string($db,$_POST['password']);
  $confirm = mysqli_real_escape_string($db,$_POST['confirm']);


  if(empty($username)) { array_push($errors,"Username is required");};
  if(empty($email)) { array_push($errors,"Email is required");};
  if(empty($password)) {array_push($errors,"Password is required");};
  if(empty($confirm)) {array_push($errors,"Confirm is required");};
  if($password !== $confirm) { array_push($errors,"Password and confirm must have the same value");};
  $query_check_users = "SELECT * FROM users WHERE '$username' = username or '$email' = email LIMIT 1";
  $reuslts = mysqli_query($db,$query_check_users);
  $user = mysqli_fetch_assoc($reuslts);
  if($user){
    if($user['username'] === $username) { array_push($errors,"Username already exists");};
    if($user['email'] === $email) { array_push($errors,"This email has a registered username");}
  } 
  if(count($errors) === 0){
 $avatar = "avatars/avatar.jpg";
    $query = "INSERT INTO users (username,email,password,avatar) VALUES ('$username','$email','$password','$avatar')";
      $result = mysqli_query($db,$query);
    header('location: main.php');
   
  }
}

if(isset($_POST['log_btn'])){
    $logUsername = mysqli_real_escape_string($db,$_POST['logUsername']);
    $logPassword = mysqli_real_escape_string($db,$_POST['logPassword']);

    if(empty($logUsername)) { array_push($logErrors,"Username is required");}
    if(empty($logPassword)) { array_push($logErrors,"Password is required");}

    if(count($logErrors) === 0){
        $check_query = "SELECT * FROM users WHERE username = '$logUsername' and password = '$logPassword'";
        $result = mysqli_query($db,$check_query);
       if(mysqli_num_rows($result)){
           header("location: main.php");
           $row = mysqli_fetch_array($result);
           $_SESSION['username'] = $logUsername;
           $_SESSION['email'] = $row['email'];
           $_SESSION['id'] = $row['id'];
           $_SESSION['success'] = "Logged in succesfully";
           $username = $_SESSION['username'];
           $isActive = "online";
           $query = "UPDATE users SET isActive = '$isActive' WHERE username = '$username'";
           $result = mysqli_query($db,$query);
       }
       else{
           array_push($logErrors,"Username or password are invalid");
       }
    }
}

?>