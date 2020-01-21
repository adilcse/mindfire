<style>
<?php
session_start();
if(!$_SESSION["LoggedIn"]){
  $_SESSION["login-error"]="please login first";
  header("Location: /login.php"); 
}
$username=$_SESSION["username"] ;
    include('headerStyle.css');

?>
</style>
<div class="header">
  <a href="/" class="logo"><img src="logo.jpg" width="150px" height="80px">
<div class="welcome-msg"></div>
</a>
  
  <div class="header-right">
    
    <a class="<?php echo $home ;?>" href="/">Home</a>
    <a class="<?php echo $profile ;?>" href="/profile/profile.php">profile</a>
    <a class="<?php echo $about ;?>" href="/about/about.php">About</a>
    <a  href="/index.php?logout=true">Logout</a>
  </div>
</div>