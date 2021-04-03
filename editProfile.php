<?php 
session_start();
     $db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");
    
     
         $id = $_SESSION['id'];
         $query = "SELECT * FROM users WHERE id = $id";
         $result = mysqli_query($db,$query);
         $user = mysqli_fetch_array($result);
         $username = $user['username'];
         $email = $user['email'];
         $password = $user['password'];
         $bio = $user['Bio'];
        $firstName = $user['FirstName'];
        $lastName = $user['LastName'];
         
        
     


  if(isset($_POST['update'])){
      $firstname = $_POST['firstName'];
      $lastname = $_POST['lastName'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $bio = $_POST['bio'];


      $query = "UPDATE users SET username = '$username',email = '$email',password='$password',FirstName = '$firstname',LastName = '$lastname',Bio = '$bio' WHERE id = $id";
      $result = mysqli_query($db,$query);
      header("location: main.php");
  }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post"> 
      <input type="text" value="<?php echo $firstName; ?>" name="firstName" placeholder="First Name">
      <input type="text" value="<?php echo $lastName; ?>" name="lastName" placeholder="Last Name">
       <input type="text" value="<?php echo $username;?>" name="username" placeholder="Username">
       <input type="email" value="<?php echo $email; ?>" name="email" placeholder="Email">
       <input type="password" value="<?php echo $password; ?>" name="password" placeholder="Password">
      <input type="text" value="<?php echo $bio; ?>" placeholder="bio" name="bio">
      <input type="submit" value="Update Profile" name="update">
    </form>
</body>
</html>