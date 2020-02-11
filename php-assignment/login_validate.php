<?php
require_once 'vendor/autoload.php';
require_once('profiledb/dbConnectpdo.php');
	session_start();
	

	if (!empty($_POST))
	{
		if($_POST['google']==="true"){
			$CLIENT_ID = "14597457274-6f120scjmftf012ru7i1e24hs5ecf6vl.apps.googleusercontent.com";
			$id_token = $_POST["user_token"];
			$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
			$payload = $client->verifyIdToken($id_token);
			if ($payload) {
				
			if($id=checkUserExist($payload)){
				signIn($id,$payload['email']);
				die("googleSignedIn");
			}else{
				RegisterAndSignIn($payload);
			}
			echo "googleSignedIn";
			} else {
				echo "error";
			// Invalid ID token
			}
			
			die;
			
		}
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
				signIn($result["id"],$uid);
				
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

	function checkUserExist($payload){
		$DBConnector = DataBaseConnecter::getInstance(); 
		$username = $payload['email'];
		try{
			if($DBConnector->getConnect()){
		$resultAll = $DBConnector->selectFromMysql("user_credentials",["user_name","password","id"],["user_name"=>$username]);
		$result = $resultAll[0];

		if($result){
			return $result['id'];
			}
			else{
				return false;
			}
		}else{
			die("error");
		}
		return false;
	}catch(Exception $e){
		die("error");
	}
		
	}
	function signIn($uid,$username){
		$_SESSION["uid"]=$uid;
		$_SESSION["username"]=$username;
		$_SESSION["LoggedIn"]=true;
		$_SESSION["login-error"]=NULL;
	
	}
	function registerAndSignin($payload){
		$DBConnector = DataBaseConnecter::getInstance(); 
		$username=$payload['email'];
		if($DBConnector->insertIntoMysql("user_credentials",["user_name","password"],[$username,"NOT_REQUIRED"])){
			$resultAll = $DBConnector->selectFromMysql("user_credentials",["id"],["user_name"=>$username]);
			$result = $resultAll[0];
			if($result){
				$table ="users";
				$columns = ["first_name"=>$payload['given_name'],"last_name"=>$payload['family_name'],"email"=>$payload['email'],"image_address"=>$payload['picture']];
				$con = ["id"=>$result['id']];
			   $resultSuccess = $DBConnector->updateMysql($table,$columns,$con);
			   if($resultSuccess){
				signIn($result['id'],$username);
				die("googleSignedIn");
			   }else
			   	die("error");
				
			}else{
				die("error");
			}
		}
		else{
			die("error");
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