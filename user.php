<?php 
  session_start();
     $db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");

  if(isset($_GET['user'])){
      $id = $_GET['user']; 
      if($id === $_SESSION['id']){
          header("location: main.php");
      }
      $user_check_query = "SELECT * FROM users WHERE id = $id";
      $result = mysqli_query($db,$user_check_query);
      if(mysqli_num_rows($result) === 1){
          $user = mysqli_fetch_array($result);
          $username = $user['username'];
          $email = $user['email'];
          $avatarUrl = $user['avatar'];
          $id = $user['id'];
          $isActive = $user['isActive'];
          $bio = $user['Bio'];
          $firstName = $user['FirstName'];
          $lastName = $user['LastName'];
      }
    }

 if(isset($_POST['follow'])){
     $fromId = $_SESSION['id'];
     $toId = $_GET['user'];
     $query = "INSERT INTO follow (fromUser,toUser) VALUES ($fromId,$toId)";
     $result = mysqli_query($db,$query);
    }
  if(isset($_POST['unfollow'])){
    $fromId = $_SESSION['id'];
    $toId = $_GET['user'];
      $unflw_query = "DELETE FROM follow WHERE fromUser = $fromId and toUser = $toId";
      $unflw_result = mysqli_query($db,$unflw_query);
  }

 $fromId = $_SESSION['id'];
 $toId = $_GET['user'];
 $follow_query = "SELECT * FROM follow WHERE fromUser = $fromId and toUser = $toId";
 $follow_result = mysqli_query($db,$follow_query);

 $toId = $_GET['user'];
 $follower = "SELECT * FROM follow WHERE toUser = $toId";
 $flwer_result = mysqli_query($db,$follower);
 $following = "SELECT * FROM follow WHERE fromUser = $toId";
 $flwing_result = mysqli_query($db,$following);

 $followers = mysqli_num_rows($flwer_result);
 $followings = mysqli_num_rows($flwing_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/userPage.css">
    <title>Document</title>
</head>
<body>
   <img src="<?php echo $avatarUrl; ?>" style="width:300px;height:300px;border-radius:50%;">
    <h1><?php echo $username; ?></h1>
    <p><?php echo $isActive; ?></p>
    <p><span>First Name:</span><?php echo $firstName; ?></p>
    <p><span>Last Name:</span><?php echo $lastName; ?></p>
    <p><span>Bio:</span><?php echo $bio; ?></p>
    <a href="main.php">Go to main page</a>
    <a href="message.php?user=<?php echo $id; ?>">Messages</a>
    <?php if(mysqli_num_rows($follow_result)) : ?>
    <form method="post">
        <input type="submit" value="Unfollow" name="unfollow">
    </form>
  <?php else : ?>
  <form method="post">
  <input type="submit" name="follow" value="Follow">
    </form>
    <?php endif ?>
    <!-- FOLLOWERS -->
    <p class="seefollowers" style="cursor:pointer;">Followers:<?php echo $followers; ?></p>
  

<!-- MODAL OF FOLLOWERS -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" >
  <span class="close">&times;</span>
  <?php 
       $id = $_GET['user'];
       $allfollower = "SELECT * FROM follow WHERE toUser = $id";
       $all_flw_result = mysqli_query($db,$follower);
       if(mysqli_num_rows($all_flw_result) > 0){
         while($row = mysqli_fetch_assoc($all_flw_result)){
           $fromId = $row['fromUser'];
           $all_query = "SELECT * FROM users WHERE id = $fromId ORDER BY username";
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
    <!-- FOLLOWINGS -->
    <p class="seeFollowings" style="cursor:pointer;">Followings:<?php echo $followings; ?></p>
    <!-- MODAL OF FOLLOWINGS -->
    <div id="followingModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content" >
  <span class="close">&times;</span>
  <?php 
       $id = $_GET['user'];
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
   

<?php
$id = $_GET['user'];
  $check_query = "SELECT * FROM posts  WHERE user_id = $id ORDER BY time DESC";
  $result = mysqli_query($db,$check_query);
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $postUrl = $row['postUrl'];
      $post_id = $row['post_id'];
      $context = $row['text'];
      $id = $row['user_id'];
      $user_query = "SELECT * FROM users WHERE id = $id";
      $user_result = mysqli_query($db,$user_query);
      $user_row = mysqli_fetch_assoc($user_result);
      $username = $user_row['username'];
      $avatar = $user_row['avatar'];
      echo "<div onclick=seePost($post_id)>
      <div>
      <img src='$avatar' style=width:100px;height:100px;border-radius:50%;>
      <p>$username</p>
      </div>
      <img src='$postUrl' style=width:400px;height:400px>
      <p><b>$username</b>$context</p>
      <form method=post>
         <input type=button value=Like name=like>
       </form>
      </div>";
    }
  }
  else{
    echo "No posts yet";
  }
?>
    <script>
 var modal = document.querySelector("#myModal");
 var modal1 = document.querySelector('#followingModal')
// Get the button that opens the modal
var seeFollowers = document.querySelector(".seefollowers");
var seeFollowings = document.querySelector(".seeFollowings")
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span1 = document.getElementsByClassName("close")[1];
// When the user clicks on the button, open the modal
seeFollowers.addEventListener("click",function() {
  modal.style.display = "block";
})

seeFollowings.addEventListener("click",()=>{
  modal1.style.display = "block";
})

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

span1.onclick = function(){
   modal1.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  else if(event.target == modal1){
    modal1.style.display == "none";
  }
}

function gotoUserPageOfFollow(n){
  window.location.assign(`user.php?user=${n}`);
}

function seePost(n){
  window.location.assign(`post.php?post=${n}`)
}
</script>
</body>
</html>
