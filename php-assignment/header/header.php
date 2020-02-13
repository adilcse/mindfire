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
<script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
  <script>
    function init() {
  gapi.load('auth2', function() {
    /* Ready. Make a call to gapi.auth2.init or some other API */
    gapi.auth2.init({
      client_id: '14597457274-6f120scjmftf012ru7i1e24hs5ecf6vl.apps.googleusercontent.com'
    })
  });
}
    </script>
<div class="header">
  <a href="/" class="logo"><img src="/header/logo.jpg" width="150px" height="80px">
<div class="welcome-msg"></div>
</a>
  <!-- create header -->
  <div class="header-right">
    
    <a class="<?php echo $home ;?>" href="/">Home</a>
    <a class="<?php echo $profile ;?>" href="/profiledb/profile.php">profile</a>
    <a class="<?php echo $post ;?>" href="/posts/controller.php">Post</a>
    <a class="<?php echo $about ;?>" href="/about/about.php">About</a>
    <a  href="/index.php?logout=true" onClick="logout()">Logout</a>
  </div>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
<script>

  function logout() {
   
   
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>
</div>