<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">

    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    include('databaseConnect.php');
    if (!empty($_POST))
    {
        $uid=$_POST["username"];
        $password=$_POST["password"];
        
       $sql="SELECT user_name,password,id from user_credentials WHERE user_name='$uid' LIMIT 1;";
    //    var_dump($sql);die();
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($uid === $row["user_name"] && password_verify($password, $row["password"])){
                $_SESSION["uid"]=$row["id"];
                $_SESSION["username"]=$uid;
                $_SESSION["LoggedIn"]=true;
                $_SESSION["login-error"]=NULL;
                header("Location: /index.php"); 
            }
           else{
            $_SESSION["username"]=NULL;
            $_SESSION["LoggedIn"]=false;
            $_SESSION["login-error"]="username or password incorrect";
           }
            
        }
    } else {
        $_SESSION["username"]=NULL;
        $_SESSION["LoggedIn"]=false;
        $_SESSION["login-error"]="username not exist";
    }
    }
    ?>
    <div class="container">
        <div class="d-flex   justify-content-center h-100">
            <div class="card">
                <div class="card-header  d-flex justify-content-center">
                    <h3>Login</h3>
                  
                </div>
                <div class="card-body">
                    <form action="login.php" method="POST">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="username" placeholder="username" id="username" minlength="4" required>
                            
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="password" id="password" minlength="5" required>
                        </div>
                        <div class="error d-flex justify-content-center">
                            <?php echo $_SESSION["login-error"] ?>
                        </div>
                        <div class="d-flex justify-content-center">
                        <div class="form-group">
                                <input type="submit" value="Login" class="btn float-right login_btn">
                            </div>   
                        <div class="form-group">
                                <input type="reset" value="Reset" class="btn float-right reset_btn">
                            </div>
                           
                        </div>
                     
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                       hint : mindfire
                </div>
            </div>
        </div>
    </div>
   
</body>

</html>