<?php 
 session_start();
 $db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");
  $errors = array();
  
 $id = $_SESSION['id'];
  $query = "SELECT * FROM users WHERE id = $id";
  $result = mysqli_query($db,$query);
  $user = mysqli_fetch_array($result);
  $firstName = $user['FirstName'];
  $lastName = $user['LastName'];
  $bio = $user['Bio'];
   $username = $user['username'];
  $email = $user['email'];
 if(!isset($_SESSION['username'])){
     header('location: login.php');
 } 
  
 if(isset($_GET['logout'])){

   session_destroy();
   $isActive = "offline";
   $query = "UPDATE users SET isActive = '$isActive' WHERE username = '$username'";
   $result = mysqli_query($db,$query);
  $username = $_SESSION['username'];
   unset($_SESSION['username']);
   header('location: main.php');
 }
 
  $id = $_SESSION['id'];
 if(isset($_POST['uploadAvatar'])){
   if(!empty($_FILES['file']['name'])){
     if($_FILES['file']['type'] === "image/jpeg" || $_FILES['file']['type'] === "image/png"){
   $file = $_FILES["file"];
   $fileTmpName = $file['tmp_name'];
   $url = "avatars/".$file['name'];
   move_uploaded_file($fileTmpName,$url);

   $change_avatar_query = "UPDATE users SET avatar = '$url' WHERE id = $id";
   $change_avatar_result = mysqli_query($db,$change_avatar_query);
     }else{
       array_push($errors,"choos image type of file");
     }
   }else{
     array_push($errors,"Select an image to upload a file");
   }
   
   }



   $follower = "SELECT * FROM follow WHERE toUser = $id";
   $flw_result = mysqli_query($db,$follower);
   $following = "SELECT * FROM follow WHERE fromUser = $id";
   $flwing_result = mysqli_query($db,$following);
   $followers = mysqli_num_rows($flw_result);
   $followings = mysqli_num_rows($flwing_result);


    // post button clicked
    if(isset($_POST['Upload-Post'])){
      $id = $_SESSION['id'];
      $file = $_FILES['postsFile'];
      $fileName = $file['name'];
      $fileUrl = "posts/$fileName";
      $text = $_POST["postsText"];
      $move = move_uploaded_file($file['tmp_name'],$fileUrl);
      
      $query = "INSERT INTO posts (user_id,text,postUrl) VALUES ($id,'$text','$fileUrl')";
      $result = mysqli_query($db,$query);
    }
      
   $avatar_query = "SELECT * FROM users WHERE id = $id";
   $avatar_result = mysqli_query($db,$avatar_query);
   $avatar_row = mysqli_fetch_array($avatar_result);
   $avatarUrl = $avatar_row['avatar'];
  ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/mainPage.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Home Page</title>
    <!-- js -->
<script> 

</script>
</head>
<body>

     <?php include("navbar.php") ?>
    <h3>Welcome <?php echo $_SESSION['username']; ?></h3>  

    <button><a href="main.php?logout=1">Log Out</a></button><br>
     
    <img src="<?php echo $avatarUrl; ?>" alt="avatar" style="width:300px;height:300px;border-radius:50%;">
      <?php foreach($errors as $error) : ?>
      <p>*<?php echo $error;?></p>
      <?php endforeach ?>
    <form  method="post" enctype="multipart/form-data">
      <input type="file" name="file">
      <input type="submit" value="Upload Profile Img" name="uploadAvatar">
    </form>
    <p class="seefollowers" style="cursor:pointer;">Followers:<?php echo $followers; ?></p>
  

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" >
  <span class="close">&times;</span>
  <?php 
       $id = $_SESSION['id'];
       $allfollower = "SELECT * FROM follow WHERE toUser = $id ORDER BY username";
       $all_flw_result = mysqli_query($db,$follower);
       if(mysqli_num_rows($all_flw_result) > 0){
         while($row = mysqli_fetch_assoc($all_flw_result)){
           $fromId = $row['fromUser'];
           $all_query = "SELECT * FROM users WHERE id = $fromId";
           $all_result = mysqli_query($db,$all_query);
          $row = mysqli_fetch_assoc($all_result);
          $id = $row['id'];
             $username = $row['username'];
             $FirstName = $row['FirstName'];
             $LastName = $row['LastName'];
             $avatarUrl = $row['avatar'];

             echo "<div class='followerUsers' onclick=gotoUserPageOfFollow($id)>
                <img src='$avatarUrl' style=width:50px;height:50px;border-radius:50%;>
                <div>
                <p style=padding-left:10px;>$username</p>
                </div>
             </div>";
         }
        }
   ?>
  </div>
</div>
    <p class="seeFollowings">Followings:<?php echo $followings; ?></p>
    <div id="followingModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" >
  <span class="close">&times;</span>
  <?php 
       $id = $_SESSION['id'];
       $allfollower = "SELECT * FROM follow WHERE fromUser = $id";
       $all_flw_result = mysqli_query($db,$allfollower);
       if(mysqli_num_rows($all_flw_result) > 0){
         while($row = mysqli_fetch_assoc($all_flw_result)){
           $toId = $row['toUser'];
           $all_query = "SELECT * FROM users WHERE id = $toId ORDER BY username";
           $all_result = mysqli_query($db,$all_query);
          $row = mysqli_fetch_assoc($all_result);
          $id = $row['id'];
             $username = $row['username'];
             $FirstName = $row['FirstName'];
             $LastName = $row['LastName'];
             $avatarUrl = $row['avatar'];

             echo "<div class='followerUsers' onclick=gotoUserPageOfFollow($id)>
                <img src='$avatarUrl' style=width:50px;height:50px;border-radius:50%;>
                <div>
                <p style=padding-left:10px;>$username</p>
                </div>
             </div>";
         }
        }
   ?>
  </div>
</div>
 
    <a href="message.php">Direct</a>
    <button><a href="editProfile.php">Edit your profile</a></button>
  
  <!-- upload posts -->
  <form  method="post" enctype="multipart/form-data">
    <input type="file" name="postsFile">
    <input type="text" name="postsText" placeholder="Enter a context">
   <input type="submit" value="Upload Post" name="Upload-Post">
  </form>
  <h1>Your posts</h1>
<?php
$id = $_SESSION['id'];
  $check_query = "SELECT * FROM posts  WHERE user_id = $id ORDER BY time DESC";
  $result = mysqli_query($db,$check_query);
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $postUrl = $row['postUrl'];
      $context = $row['text'];
      $post_id = $row['post_id'];
      $id = $row['user_id'];
      $user_query = "SELECT * FROM users WHERE id = $id";
      $user_result = mysqli_query($db,$user_query);
      $user_row = mysqli_fetch_assoc($user_result);
      $username = $user_row['username'];
      $avatar = $user_row['avatar'];
    



      echo "<div class=post>
      <div onclick=seePost($post_id)>
      <div class=post_header>
      <img src='$avatar' style=width:100px;height:100px;border-radius:50%;>
      <p>$username</p>
      </div>
      <div class=img-container>
      <img src='$postUrl' style=width:400px;height:400px>
      <div>
      <div class=post_footer>
      <p><b>$username</b>$context</p>
    </div>
    </div>
    </div>
      </div>";
      
      
    }
    if(isset($_POST['post_comment'])){
      $text = $_POST['comment_text'];
       $comment_post_query = "INSERT INTO comment (user_id,post_id,text) VALUES ($id,$post_id,'$text')";
       $comment_post_result = mysqli_query($db,$comment_post_query);
     }
  }
  else{
    echo "Make a post";
  }
?>

</body>

</html>
<?php 
   
?>