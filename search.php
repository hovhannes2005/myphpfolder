<?php 
session_start();
$db = mysqli_connect("localhost","root","","login") or die("Couldnt connect to database");
 if(isset($_POST['search'])){
   $search = $_POST['search'];
   if(!empty($search)){
     $username = $_SESSION['username'];
     $search_query = "SELECT * FROM users WHERE username != '$username' and username LIKE '%$search%'";
     $search_query_result = mysqli_query($db,$search_query);
     while($search_result = mysqli_fetch_array($search_query_result)){
       $id = $search_result['id'];
       $username = $search_result['username'];
       $avatar = $search_result['avatar'];
       echo "<div style=display:flex;align-items:center;padding:5px;width:200px; class=search_result onclick=gotoUserPage($id)>
         <img src='$avatar' style=width:50px;height:50px;border-radius:50%;>
         <p>$username</p>
       </div>";
     }
   
   }
 }
?>
<style>
   .search_result:hover{
     background: lightgray;
     cursor: pointer;
   }
</style>

<script>
   function gotoUserPage(n){
     window.location.assign(`user.php?user=${n}`)
   }
</script>