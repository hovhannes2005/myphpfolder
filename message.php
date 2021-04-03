<?php
  session_start();
  $db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");
 
  
  if(isset($_GET['user'])){
      $userId = $_GET['user'];
      
      $user_check_query = "SELECT * FROM users WHERE id = $userId";
      $result = mysqli_query($db,$user_check_query);
      if(mysqli_num_rows($result)){
          $user = mysqli_fetch_array($result);
          $toId = $user['id'];
          $toUsername = $user['username'];
        }
        
        $username = $_SESSION['username'];
        
        $user_check_query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($db,$user_check_query);
        if(mysqli_num_rows($result)){
            $user = mysqli_fetch_array($result);
            $fromId = $user['id'];
            $fromUsername = $user['username'];
        }
        
    }
    if(isset($_POST['send'])){
          if(isset($fromUsername) && isset($toUsername)){
              if(!empty($_POST['message']))
              $message = $_POST['message'];
              $query = "INSERT INTO messages (fromUser,toUser,text) VALUES ($fromId,$toId,'$message')";
              $result = mysqli_query($db,$query);
              

            }
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Message.css">
    <title>Document</title>
</head>
<body>
  
  
    <?php if(isset($_GET['user'])) : ?>
      <div class="container">
      <div class="users_container">
     
     <?php 

       $id = $_SESSION['id'];
       $flw_check_query = "SELECT * FROM follow WHERE fromUser = $id";
       $flw_result = mysqli_query($db,$flw_check_query);
        while($row = mysqli_fetch_assoc($flw_result)){
          
         $toId = $row['toUser'];
         
         $user_query = "SELECT * FROM users WHERE id = $toId";
         $result = mysqli_query($db,$user_query);
         $row = mysqli_fetch_assoc($result);
           $username = $row['username'];
           $isActive = $row['isActive'];
           $id = $row['id'];
         $avatarUrl = $row['avatar'];
      
         echo "<div class=user_container onclick=messageHim($id)>
         <img src='$avatarUrl' style=width:50px;height:50px;border-radius:50%;>
           <p>$username</p>
        
         </div>";
      
       }
     ?>
   </div>
<div>
    <div style="border-bottom:1px solid lightgray;">
       <p><?php echo $toUsername; ?></p>
      </div>
      <div   class="message_container">
  <?php 
  
    $fromId = $_SESSION['id'];
    $toId = $_GET['user'];
     $message_query = "SELECT * FROM messages WHERE fromUser = $fromId and toUser = $toId or fromUser = $toId and toUser = $fromId";
     $message_result = mysqli_query($db,$message_query);
     while($row = mysqli_fetch_assoc($message_result)){
        $from = $row['fromUser'];
        $to = $row['toUser'];
        $text = $row['text'];
        $time = $row['time'];

          $user_query = "SELECT * FROM users WHERE id = $toId";
          $user_result = mysqli_query($db,$user_query);
          $user_arr = mysqli_fetch_array($user_result);
          $avatarUrl = $user_arr['avatar']; 
      if($from === $fromId){
    
          echo "<div style=display:flex;margin-left:700px;margin-top:5px;>
           <div style=background:dodgerblue;max-width:300px;width:100%;padding:5px;border-radius:20px;>  
          <p style=color:white>$text</p>         
             <small style=color:white;>$time</small>
             </div>
             
          </div>";
      }  
      if($from === $toId){
     
     
       
          echo "<div style=display:flex;margin-left:50px;margin-top:5px;>
          <img src='$avatarUrl' style=width:40px;height:40px;border-radius:50%;align-self:flex-end; onclick=gotoUserPage($toId)> 
          <div style=background:gray;max-width:300px;width:100%;padding:5px;border-radius:20px;margin-left:5px;>  
         <p style=color:white>$text</p>         
            <small style=color:white;>$time</small>
            </div>
         </div>";
      }
     }
  ?>
  </div>
  </div>
    </div>
     <form  method="post" style="display:flex;justify-content:center;">
    <input type="text" placeholder="Message..." autocomplete="off" class="message" name="message" style="width:800px;height:30px;outline:none;border:none;border-bottom:1px solid black;">
    <input type="submit" value="Send Message" name="send"> 
    </form>
  <?php else: ?>
    <div class="users_container">
     
     <?php 
       $db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");

       $id = $_SESSION['id'];
       $flw_check_query = "SELECT * FROM follow WHERE fromUser = $id";
       $flw_result = mysqli_query($db,$flw_check_query);
        while($row = mysqli_fetch_assoc($flw_result)){
          
         $toId = $row['toUser'];
         $user_query = "SELECT * FROM users WHERE id = $toId";
         $result = mysqli_query($db,$user_query);
         while($row = mysqli_fetch_assoc($result)){
           $username = $row['username'];
           $id = $row['id'];
        if(file_exists("avatars/".$id."avatar.jpg")){
         $avatarUrl = "avatars/".$id."avatar.jpg";
       }
       else{
         $avatarUrl = "avatars/avatar.jpg";
       }
      
         echo "<div class=user_container onclick=messageHim($id)>
         <img src=$avatarUrl style=width:50px;height:50px;border-radius:50%;>
           <p>$username</p>
         
         </div>";
      }
       }
     ?>
   </div>
     <p style="text-align:center;">  Choose a Room to send message </p>
    
    <?php endif ?>  
    <script type="text/javascript">
     var element = document.querySelector(".message_container")
     element.scrollTop = element.scrollHeight;

    function messageHim(n){

      window.location.assign('message.php?user='+n)
    }

    function gotoUserPage(n){
      window.location.assign('user.php?user='+n)
    }
  </script>
</body>
</html>