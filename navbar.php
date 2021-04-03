<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/23e050e961.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script> 
 $(document).ready(function() {
   $(".searchInput").keyup(function(){
     var name = $(".searchInput").val();
     $.post("search.php", {
       search : name
     },function(data, status){
         $("#search").html(data);
     })
   })
 })
</script>
  <nav >

<!-- Links -->
<ul class="navbar-nav" >
<a class="navbar-brand" href="main.php"><img src="imgs/FreeTimelogo.png" alt="logo" width="40px"></a>
  <li class="nav-item" >
    <a href="message.php"><i class="fab fa-facebook-messenger"></i></a>
  </li>
  <li class="nav-item">
    <a href="main.php"><i class="fas fa-user-circle"></i></a>
  </li>
  <li class="nav-item">
  <input type="text" placeholder="Search..." class="form-control searchInput">
<div id="search" class="container"></div>
  </li>
</ul>
</nav>

<style>
 i{
     font-size:40px;
     color:black;
     cursor: pointer;
 }
</style>