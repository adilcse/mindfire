<style>
<?php
session_start();
if(!$_SESSION["LoggedIn"]){
  $_SESSION["login-error"]="please login first";
  header("Location: http://other.com/login.php"); 
}
$username=$_SESSION["username"] ;
    include('headerStyle.css');

?>
</style>
<div class="header">
  <a href="http://other.com" class="logo"><img src="/header/logo.jpg" width="150px" height="80px">
<div class="welcome-msg"></div>
</a>
  
  <div class="header-right">
    
    <a class="<?php echo $home ;?>" href="http://other.com">Home</a>
    <a class="<?php echo $profile ;?>" href="http://other.com/profile/profile.php">profile</a>
    <a class="<?php echo $about ;?>" href="http://other.com/about/about.php">About</a>
    <a  href="http://other.com/index.php?logout=true">Logout</a>
  </div>
</div>