<?php 
session_start();
if($_GET["logout"]){
    session_destroy();
    setcookie("username", "", time() - 3600);
    setcookie("uid", "", time() - 3600);
    header("Location: /login.php"); 
}

$home="active";
?> 
<html lang="en">
<head>
    <meta charset="UTF-8">
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>welcome</title>
    <link rel="stylesheet" href="index.css"/>
    
</head>
<body>
    <?php include("header/header.php"); ?>
  
      <div class="index-body">
        <table class="clonepage" width="100%" align="center">
            <tbody>
              <tr>
                <td align="center" class="body-headding">
                  <h1 class="welcome-heading">Welcome to Mindfire Solutions</h1>
                </td>
              </tr>
            <tr>
             <td align="left" class="body-content">	
                <p class="welcome-content">We are a work-focused unit of <strong>650+ people, 19 years old</strong>, that is just 
                focused on doing good tech work.
                </p><p>We do only one thing - <b>Offshore Small Team Software Development</b></a> - and we do it very well. From hiring to 
                testing to reviews to environment to learning to culture, we are focused 
                on being the rock-stars of software development. We are bad at sales and 
                marketing and have no intention of changing it.</p>
                
                <p>We specialize in software product development, and have delivered 
                commercial-grade systems repeatedly. We follow <b>Agile methods</b></a> and believe 
                in collaboration more than documents to get new stuff developed. We are 
                focused on getting to done, together with clients.</p>
                
                <p>We have a <b>flexible culture</b></a> and laissez-faire atmosphere that is 
                conducive to techies and geeks to flower, but is also prone to 
                misinterpretation. We know the difference between a consciously 
                un-managed organization and a mis-managed one.</p>
                
                <p>&nbsp;</p><p align="center" class="body-end"><b>We are professionals behind our tattoos.</b></p>
                <p>&nbsp;</p>
              </td>
            </tr>
            </tbody>
            </table>
      </div>
       
    <?php include("footer/footer.php"); ?>
  
</body>
</html>