<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <?php
  session_start();
   $db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");
    $post_id = $_GET['post'];
    $post_query = "SELECT * FROM posts WHERE post_id = $post_id";
    $post_result = mysqli_query($db,$post_query);
    $post = mysqli_fetch_array($post_result); 
    $user_id = $post['user_id'];
    $post_img = $post['postUrl'];
    $post_context = $post['text'];
    $user_query = "SELECT * FROM users WHERE id = $user_id";
    $user_result = mysqli_query($db,$user_query);
    $user = mysqli_fetch_array($user_result);
    $username = $user['username'];
    $avatar = $user['avatar'];


    if(isset($_POST['create_comment'])){
      $user_id = $_SESSION['id'];
      $post_id = $_GET['post'];
      $text = $_POST['comment'];
      $query = "INSERT INTO comment (user_id,post_id,text) VALUES ($user_id,$post_id,'$text')";
      $result = mysqli_query($db,$query);
    }
  ?>
    <div class="post" style="display:flex;align-items:center;justify-content:center;">
      <div class="post_container" style="border:1px solid lightgray;">
        <div class="post_header" style="display:flex;padding:5px;">
          <img src="<?php echo $avatar; ?>" alt="avatar" style="width:50px;height:50px;border-radius:50%;">
          <p><?php echo $username; ?></p>
        </div>
        <div class="img_container">
          <img src="<?php echo $post_img; ?>" alt="post_img" style="width:600px;height:600px;">
        </div>
      </div>
      <div class="comment_container" style="border:1px solid lightgray;width:400px;height:663px;">
       <div class="comments_container" style="max-height:630px;border-bottom:1px solid lightgray;">
         <div class="context_container" style="border-bottom:1px solid black;display:flex;">
            <p><img src="<?php echo $avatar; ?>" alt="avatar" style="width:50px;height:50px;border-radius:50%;"><span style="font-size:20px;font-weight:10px;"><?php echo $username; ?></span><?php echo $post_context; ?></p> 
         </div>
         <div class="comments" style="overflow:auto;">
       <?php
        $post_id = $_GET['post'];
         $cmt_query = "SELECT * FROM comment WHERE post_id = $post_id";
         $cmt_result = mysqli_query($db,$cmt_query);
         while($cmt_row = mysqli_fetch_assoc($cmt_result)){
             $text = $cmt_row['text'];
             $user_id = $cmt_row['user_id'];
             $user_query = "SELECT * FROM users WHERE id = $user_id";
             $user_result = mysqli_query($db,$user_query);
             $user = mysqli_fetch_assoc($user_result);
             $username = $user['username'];
             $avatar = $user['avatar'];
             echo "<div style=display:flex;>
                <img src='$avatar' style=width:50px;height:50px;border-radius:50%; >
                <h5>$username</h5>
                <p>$text</p>
             </div>";
         }
       ?>
         </div>
       </div>
       <div class="post_comments_container" style="padding:3px;">
         <form method="post">
            <input type="text" placeholder="Enter a context..." name="comment" style="border:none;outline:none;border-bottom:1px solid black;width:300px;">
            <input type="submit" value="Comment" name="create_comment">
         </form>
       </div>
      </div>
    </div>
</body>
</html>