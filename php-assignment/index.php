<?php 
session_start();
if(!$_SESSION["LoggedIn"]){
    header("Location: /login.php"); 
}
?> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>welcome</title>
</head>
<body>
   <h1> welcome <?php echo $_SESSION["username"] ?>  </h1>
  <a href="index.php?logout=true"><h2 > logout</h2> </a> 
</body>
<?php
if($_GET["logout"]){
    session_destroy();
    header("Location: /login.php"); 
}
 
?>
</html>