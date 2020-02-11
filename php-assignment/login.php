
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="google-signin-client_id" content="14597457274-6f120scjmftf012ru7i1e24hs5ecf6vl.apps.googleusercontent.com">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="login.css">
	<link type="text/css" rel="stylesheet" href="waitMe.min.css">

	<title>Login</title>
</head>
<body>
	
	<div class="container">
		<div class="d-flex   justify-content-center h-100">
			<div class="card">
				<div class="card-header  d-flex justify-content-center">
					<h3>Login</h3>

				</div>
				<div class="card-body">
					<form method="POST">
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
							
						</div>
						<div class=" d-flex justify-content-left">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox"  name="rememberme" id="rememberme" value="true" checked>
								<label class="form-check-label"  for="rememberme">Remember me</label>
							</div>
						</div>
						<div class="d-flex justify-content-center">
							<div class="form-group">
								<input type="button" value="Login" class="btn float-right login_btn">
							</div>
							<div class="form-group">
								<input type="reset" value="Reset" class="btn float-right reset_btn">
							</div>

						</div>

					</form>
					<div class="d-flex justify-content-center">
						<div class="g-signin2 " data-onsuccess="onSignIn"></div>
					</div>
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
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="waitMe.min.js"></script>

<script type="text/javascript">
const validateUser=(user)=>{
	const letters = /^[A-Za-z0-9]+$/;
	const email = /^[a-zA-Z]+[a-zA-Z0-9\.\_]*@[a-zA-Z]+\.[a-zA-Z]{3,}$/;
	if(user.match(email)||(user.match(letters) && user.length > 3)){
		return true;
	}
	else{
		$("div.error").text("Enter a valid username");
		return false;
	}
}
const validatePassword=(password)=>{
	const letters = /^[A-Za-z0-9]+$/;
	if(password.match(letters) && password.length > 6){
		return true;
	}
	else{
		$("div.error").text("Enter a valid password");
		return false;
	}
}
$('input[type="button"]').click(function(){
	
	let check = validateUser($('input#username').val()) && validatePassword($('input#password').val());
	
	if(check){
		var current_effect ='stretch';
		run_waitMe(current_effect);
		const postData = {
			"username" : $('input#username').val(),
			"password" : $('input#password').val()

		}
		$.ajax({
			url: "login_validate.php", 
			data: postData ,
			method :"POST",
			success: function(result){
				console.log(result);
				if(result.includes("success")){
					window.location.replace("index.php");
				}else if(result.includes("userNotExist")){
					$("div.error").text("User not Exist");	
				}else if(result.includes("connectionFailed")){
					$("div.error").text("connection Failed");	
				}
				else if(result.includes("incorrect")){
					$("div.error").text("Incorrect password");	
				}

			$(".card").waitMe("hide");	
			},
			error : function(e){
				$(".card").waitMe("hide");	
			}
		});

	}
});
function run_waitMe(effect){
	13
$('.card').waitMe({
	effect:effect,
	text:'Logging in',
	bg:'rgba(0,0,0,0.7)',
	color:'#ffffff',
	textPos:'vertical',
});

}
function onSignIn(googleUser) {
	var current_effect ='stretch';
		run_waitMe(current_effect);
  var profile = googleUser.getBasicProfile();
  var id_token = googleUser.getAuthResponse().id_token;
  let postData = {
			"user_token" : id_token,
			"google" : "true"

		}
  $.ajax({
			url: "login_validate.php", 
			data: postData ,
			method :"POST",
			success: function(result){
				console.log(result);
				if(result.includes("success")){
					window.location.replace("index.php");
				}else if(result.includes("googleSignedIn")){
					window.location.replace("index.php");
				}else if(result.includes("connectionFailed")){
					$("div.error").text("connection Failed");	
				}else if(result.includes("error")){
					$("div.error").text("google signin failed");	
				}	
				$(".card").waitMe("hide");		
			},
			error: function(e){
				$(".card").waitMe("hide");	
			}
  	});
//   console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
//   console.log('Name: ' + profile.getName());
//   console.log('Image URL: ' + profile.getImageUrl());
//   console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}

</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>

</body>
<?php
$_SESSION["login-error"]=NULL;
?>

</html>