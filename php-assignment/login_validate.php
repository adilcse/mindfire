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
			echo "userNotExist";

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
				echo "success";
			}
		   else{
			$_SESSION["username"]=NULL;
			$_SESSION["LoggedIn"]=false;
            $_SESSION["login-error"]="username or password incorrect";
            echo "incorrect";
		   }


	} else {
		$_SESSION["username"]=NULL;
		$_SESSION["LoggedIn"]=false;
        $_SESSION["login-error"]="username not exist ";
        echo "userNotExist";
		}
	}
	else{
        $_SESSION["login-error"]="Connection failed,Check your network connection";
        echo "connectionFailed" ;
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
				echo "success";
				}
				else{
					setcookie("uid","null", time() - 3600, "/");
					setcookie("username","null", time() - 3600, "/");
				}
				
			}
		}	
	}
	?>