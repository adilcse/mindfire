<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="profileStyle.css">
		<title>profile</title>
		<?php
			session_start();
			$profile="active";
		?>
	</head>
	<body>
		<?php include("../header/header.php");
			include('dbConnectpdo.php');
			$name=$email=$mobile_number=$age=$gender=$img=$resume_link=$state='';
			if(!empty($_SESSION['uid'])){
				//select user data
			$table="users";
			$columns=["users.first_name","users.last_name","users.email","users.mobile_number","users.age","users.sex","users.image_address","users.resume_address","users.state_id"];
			$condition=["users.id"=>$_SESSION['uid']];
			$lmt="LIMIT 1";
			$resultAll = $DBConnector->selectFromMysql($table,$columns,$condition,$lmt);
			if($resultAll)
				{
					try{
				$result = $resultAll[0];
					if ($result) {
					//get profile details
						$name=$result['first_name']." ".$result['last_name'];
						$email=$result['email'];
						$mobile_number=$result['mobile_number'];
						$gender=$result['sex'];
						$state=$result['state_id'];
						$age=$result['age'];
						$img = $result['image_address'];
						$resume_link=$result['resume_address'];


					}
					if(!$img){
						$img ="https://banner2.cleanpng.com/20180521/ocp/kisspng-computer-icons-user-profile-avatar-french-people-5b0365e4f1ce65.9760504415269493489905.jpg";
					}
				}catch(Exception $e){
					// die($conn->error);
					die("<h1> something went wrong </h1>");
				}
			}
			else{
				die("<h1> something went wrong </h1>");
			}
			}else{
				header("Location: ../login.php");
			}
		?>
		<div class="profile-body">
			<div class="container">
				<!-- display if any error present -->
				<?php
					if($_SESSION["profile-error"]=='true')
					{
						echo ' <div class="alert alert-danger text-center" role="alert">
						'.$_SESSION["profile-msg"].' </div>';
					}else if($_SESSION['profile-error']=='false'){
						echo ' <div class="alert alert-success text-center" role="alert">
						'.$_SESSION["profile-msg"].' </div>';
					}
					$_SESSION["profile-error"]="none";
					$_SESSION["profile-msg"]="none";

				?>
				<div class="row main">
					<form method="POST" action="profileValidate.php" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="username">User name</label>
									<input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['username']?>" disabled>
								</div>
								<div class="form-group">
									<label for="name">Your Name</label>
									<input type="text" class="form-control" id="name" name="name" value="<?php echo $name ;?>" >
								</div>
								<div class="form-group">
									<label for="email">Email address</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?php echo $email ;?>"  required>
								</div>
								<div class="form-group">
									<label class="" for="mobileno">Mobile number</label>
									<div class="input-group mb-2 mr-sm-2">
										<div class="input-group-prepend">
											<div class="input-group-text">+91</div>
										</div>
										<input type="text" class="form-control" name="mobileno" id="mobileno" placeholder="mobile number" pattern="[789][0-9]{9}" value="<?php echo $mobile_number ;?>" required>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-4">
										<label for="username">Age</label>
										<input type="number" name="age" class="form-control" id="age" min="20" max="30" value="<?php echo $age ;?>" required>
									</div>
									<div class="form-group col-md-7 ">
										<label >Gender</label>
										<br>
										<div class="form-check form-check-inline" >
											<input class="form-check-input" type="radio" name="gender" id="gender-m" value="M" checked <?php if($gender=='M') echo 'checked'; ?>>
											<label class="form-check-label" for="gender-m">
												Male
											</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="gender" id="gender-f" value="F" <?php if($gender=='F') echo 'checked'; ?>>
											<label class="form-check-label" for="gender-f">
												Female
											</label>
										</div>
									</div>
								</div>
								<div class="col-md-9">
									<label for="validationCustom04">State</label>
									<select class="custom-select" id="validationCustom04" name="state" required>
										<option value='0' disabled selected>--select--</option>
										<?php
										$table="states";
										$columns=["state_id","state_name"];
										$resultAll = $DBConnector->selectFromMysql($table,$columns);
										foreach( $resultAll as $result){
											if ($result) {
												$is_selected ='';
												if($result['state_id'] == $state)
													$is_selected='selected';
											echo "<option value='".$result['state_id']."' ".$is_selected." name = 'state' >".$result['state_name']."</option>";
											}
										}
										?>
									</select>
									<div class="invalid-feedback">
										Please select a valid state.
									</div>
								</div>
								<div>
									<label >Skills</label><br>
									<?php
										$table="skills";
										$columns=["id","skill"];
										$resultAllskills = $DBConnector->selectFromMysql($table,$columns);
										$table="user_skills";
										$columns=["skill_id"];
										$condition = ["user_id"=>$_SESSION['uid']];
										$resultAllUserSkills = $DBConnector->selectFromMysql($table,$columns,$condition);
										$selected_skills =[];
										foreach($resultAllUserSkills as $skl)
										{
											array_push($selected_skills,$skl['skill_id']);
										}
											foreach($resultAllskills as $row) {
												$check='';
												if(in_array($row["id"],$selected_skills)){
												$check ="checked";
												}
											echo  '<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" '.$check.' name="skills[]" id="'.$row["skill"].'" value="'.$row["id"].'">
													<label class="form-check-label"  for="'.$row["skill"].'">'.$row["skill"].'</label>
												</div>';
										}
									?>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="row ">
									<div class="col">
										<img src='<?php echo $img?>'  width="200px" height="200px" class="rounded mx-auto d-block" alt="avatar" id="profilepic">
									</div>
									<div class="text-center">
										<div class="form-check ">
											<input class="form-check-input" type="checkbox" name="changeImage" id="changeImage" value="true">
											<label class="form-check-label" for="changeImage">Change Image ?</label>
										</div>
										<div class="imagebox-center">
											<input type="file" name="avatar" onchange="setphoto(this)" accept="image/png, image/jpeg, image/jpg">
										</div>
										<div class="alert alert-danger text-center" role="alert" id="imageError" hidden>
											Please select an image of size less then 1MB.
										</div>
										<div class="resume-img">
											<a href = "<?php echo $resume_link; ?>">
												<img src="https://img.icons8.com/plasticine/2x/resume.png" width="200px"  height="200px">
											</a>
											<div class="form-check ">
												<input class="form-check-input" type="checkbox" name="changeResume" id="changeResume" value="true">
												<label class="form-check-label" for="changeResume">Change Resume ?</label>
											</div>
											<div class="imagebox-center">
												<input type="file" name="resume"   accept="application/pdf" onchange="setResume(this)">
												<div class="alert alert-success text-center" role="alert" id="resume_available" <?php if($resume_link == NULL) echo 'hidden';?>>
													Resume available.
												</div>
												<div class="alert alert-danger text-center" role="alert" id="resumeError" hidden>
													Please select a document of size less then 2MB.
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row justify-center">
							<div class="text-center">
							<button type="submit" name="upload" class="btn btn-primary mr-2">Save</button>
							<button type="reset" class="btn btn-primary">Clear</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			function setphoto(p){
				let img=  document.getElementById("profilepic");
				let imgsize=p.files[0].size/(1024);
				if(imgsize<1024){
					let imgurl=URL.createObjectURL(p.files[0]);
				img.setAttribute("src",imgurl);
				return;
				}
				else{
					document.getElementById("imageError").removeAttribute("hidden");
				}
			}
		function setResume(r){
			if(r.files[0].size >(2*1024*2024)){
				document.getElementById("resumeError").removeAttribute("hidden");
				document.getElementById("resume_available").setAttribute("hidden",true);
			}
		}
		</script>
		<?php include("../footer/footer.php");?>
	</body>
</html>
