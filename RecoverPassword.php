<?php 
$db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");
if(isset($_POST['sendVerification'])){
     $email = $_POST['email'];
     $mail_query = "SELECT * FROM users WHERE email = '$email'";
     $mail_result = mysqli_query($db,$mail_query);
     if(mysqli_num_rows($mail_result)){
         $token = uniqid();
         $subject = "Verify Your Password For FreeTime";
         $msg = $token;
         ini_set("SMTP","mail.freetime.com");
         ini_set("smtp_port", "hovhannesghukasian@gmail.com");
         if(mail("hovhannesghukasian@gmail.com",$subject,$msg)){
             header("location:RecoverPassword.php?email=$email");
         }
         else{
             echo "No such email";
         }
     }
     else{
         echo "There isn't user with email";
     }
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
   <form  method="post">
     <input type="email" name="email" placeholder="Enter Email To Verify">
     <input type="submit" name="sendVerification" value="Send Email">
   </form>
   <
</body>
</html>