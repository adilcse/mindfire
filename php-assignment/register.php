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
     include('profiledb/dbConnectpdo.php');
    
    if (!empty($_POST))
    {
        $uid=$_POST["username"];
        $password=$_POST["password"];
        $cpassword=$_POST["cpassword"];
        //check  username for invalid charecter
        if(strpos($uid,",") || strpos($uid,";") || strpos($uid,"-") || strpos($uid,"\'")){
            $_SESSION["username"]=NULL;
            $_SESSION["LoggedIn"]=false;
            $_SESSION["register-error"]="please enter valid username";
            header("Location: /register.php"); 
           
        } 
        if($password == $cpassword){
            $password_hash=password_hash($password, PASSWORD_DEFAULT);
            //insert new user into db
            if($DBConnector->insertIntoMysql("user_credentials",["user_name","password"],[$uid,$password_hash])){
                $resultAll = $DBConnector->selectFromMysql("user_credentials",["id"],["user_name"=>$uid]);
                $result = $resultAll[0];
            if($result){
                $_SESSION["uid"]=$result["id"];
                $_SESSION["username"]=$uid;
                $_SESSION["LoggedIn"]=true;
                $_SESSION["register-error"]=NULL;
                header("Location: /index.php"); 
                }
            else{
                $_SESSION["username"]=NULL;
                $_SESSION["LoggedIn"]=false;
                $_SESSION["register-error"]="username or password incorrect";
            }
            }else{
                $_SESSION["username"]=NULL;
                $_SESSION["LoggedIn"]=false;
                $_SESSION["register-error"]="user already exist";
            }
        }else{
            $_SESSION["username"]=NULL;
            $_SESSION["LoggedIn"]=false;
            $_SESSION["register-error"]="passwords not matched";
        }
    }
    ?>
    <div class="container">
        <div class="d-flex   justify-content-center h-100">
            <div class="card">
                <div class="card-header  d-flex justify-content-center">
                    <h3>Register</h3>
                  
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
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
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="cpassword" placeholder="confirm password" id="cpassword" minlength="5" required>
                        </div>
                        <div class="error d-flex justify-content-center">
                            <?php echo $_SESSION["register-error"] ?>
                        </div>
                        <div class="d-flex justify-content-center">
                        <div class="form-group">
                                <input type="submit" value="Register" class="btn float-right login_btn">
                            </div>   
                        <div class="form-group">
                                <input type="reset" value="Reset" class="btn float-right reset_btn">
                            </div>
                           
                        </div>
                     
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                    <a href="login.php">
                            <button value="Register" class="btn float-right register_btn">
                              Already Registered??
                            </button>
                        </a>
                </div>
            </div>
        </div>
    </div>
   
</body>

</html>