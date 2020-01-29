<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="login.css">

	<title>Login</title>
</head>
<body>
	<?php
	session_start();
	 include('profiledb/dbConnectpdo.php');

	if (!empty($_POST))
	{

		$uid=$_POST["username"];
		$password=$_POST["password"];
		if(strpos($uid,",") and strpos($uid,";") and strpos($uid,"-") and strpos($uid,"\'")){
			$_SESSION["username"]=NULL;
			$_SESSION["LoggedIn"]=false;
			$_SESSION["login-error"]="username not exist";
			header("Location: /login.php");

		}
	   //get user name and password from db
		try{
			if($DBConnector->getConnect()){
		$resultAll = $DBConnector->selectFromMysql("user_credentials",["user_name","password","id"],["user_name"=>$uid]);
		$result = $resultAll[0];

		if($result){
			//varify password
			if($uid == $result["user_name"] && password_verify($password, $result["password"])){
				$_SESSION["uid"]=$result["id"];
				$_SESSION["username"]=$uid;
				$_SESSION["LoggedIn"]=true;
				$_SESSION["login-error"]=NULL;
				if($_POST['rememberme'] == 'true'){
					setcookie("uid",$result["id"], time() + (86400 * 10), "/");
					setcookie("username",password_hash($uid,PASSWORD_DEFAULT), time() + (86400 * 10), "/");	
				}
				header("Location: /index.php");
			}
		   else{
			$_SESSION["username"]=NULL;
			$_SESSION["LoggedIn"]=false;
			$_SESSION["login-error"]="username or password incorrect";
		   }


	} else {
		$_SESSION["username"]=NULL;
		$_SESSION["LoggedIn"]=false;
		$_SESSION["login-error"]="username not exist 1";
		}
	}
	else{
		$_SESSION["login-error"]="Connection failed,Check your network connection";
	}
	}catch(Exception $e){
		echo $e->getMessage();
	}
	}
	if(isset($_COOKIE['uid'])){
		if($DBConnector->getConnect()){
			$resultAll = $DBConnector->selectFromMysql("user_credentials",["user_name","id"],["id"=>$_COOKIE['uid']]);
			$result = $resultAll[0];
			if($result){
				if(password_verify($_COOKIE["username"], $result['user_name'])){
				$_SESSION["uid"]=$result["id"];
				$_SESSION["username"]=$result['user_name'];
				$_SESSION["LoggedIn"]=true;
				$_SESSION["login-error"]=NULL;
				header("Location: /index.php");
				}
				else{
					setcookie("uid","null", time() - 3600, "/");
					setcookie("username","null", time() - 3600, "/");
				}
				
			}
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
						<div class=" d-flex justify-content-left">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox"  name="rememberme" id="rememberme" value="true">
								<label class="form-check-label"  for="rememberme">Remember me</label>
							</div>
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
					<div class="form-group">
						<a href="register.php">
							<button value="Register" class="btn float-right login_btn">
								Register
							</button>
						</a>
							</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>