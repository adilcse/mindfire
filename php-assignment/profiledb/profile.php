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
     include("../databaseConnect.php");
     $name=$email=$mobile_number=$age=$gender=$state='';
     if(!empty($_SESSION['uid'])){
      $sql="SELECT * FROM users";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {


       }
      }
     }
    
    ?>
    <div class="profile-body">
        <div class="container">
         
                <?php
                    if($_GET["error"]=='true')
                    {
                        echo ' <div class="alert alert-danger text-center" role="alert">
                        '.$_GET["msg"].' </div>';
                    }else if($_GET['error']=='false'){
                        echo ' <div class="alert alert-success text-center" role="alert">
                        '.$_GET["msg"].' </div>';
                    }
                ?>
           
              
           
            <div class="row">
               
                    <form method="POST" action="profileValidate.php" enctype="multipart/form-data">
                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">User name</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['username']?>" disabled>
                          </div>
                        <div class="form-group">
                          <label for="name">Your Name</label>
                          <input type="text" class="form-control" id="name" name="name" value="<?php echo $_COOKIE['name'] ;?>" >
                         
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?php echo $_COOKIE['email'] ;?>"  required>
                          </div>
                          <div class="form-group">
                          <label class="" for="mobileno">Mobile number</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">+91</div>
                                </div>
                                <input type="text" class="form-control" name="mobileno" id="mobileno" placeholder="mobile number" pattern="[789][0-9]{9}" value="<?php echo $_COOKIE['mobilenumber'] ;?>" required>
                            </div>  
                          </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="username">Age</label>
                                <input type="number" name="age" class="form-control" id="age" min="20" max="30" value="<?php echo $_COOKIE['age'] ;?>" required>
                            </div>
                            <div class="form-group col-md-7 ">
                                <label >Gender</label><br>
                                <div class="form-check form-check-inline" >
                                    <input class="form-check-input" type="radio" name="gender" id="gender-m" value="M" checked <?php if($_COOKIE['gender']=='male') echo 'checked'; ?>>
                                    <label class="form-check-label" for="gender-m">
                                      Male
                                    </label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender-f" value="F" <?php if($_COOKIE['gender']=='female') echo 'checked'; ?>>
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
                              $sql="SELECT * FROM states;";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                               while($row = $result->fetch_assoc()) {
                               echo "<option value='".$row['state_id']."' name = 'state' >".$row['state_name']."</option>";
                               }
                              }
                              ?>
                              
                            </select>
                            <div class="invalid-feedback">
                              Please select a valid state.
                            </div>
                          </div>
                          <div class="">
                            <label >Skills</label><br>
                            <?php
                                $sql="SELECT * FROM skills;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                 while($row = $result->fetch_assoc()) {
                                  echo  '<div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="skills[]" id="'.$row["skill"].'" value="'.$row["id"].'">
                                  <label class="form-check-label" for="'.$row["skill"].'">'.$row["skill"].'</label>
                                </div>';
                                 }
                                } 
                            ?>
                           
                              
                              
                          </div>
                         
                 </div>
                 <div class="col-md-6">
                   <div class="row ">
                     <div class="col">
                    <img src=<?php echo $img?> width="200px" height="200px" class="rounded mx-auto d-block" alt="avatar" id="profilepic">
                     </div>
                     <div class="co text-center">
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

					
						<a href=<?php echo $resume_link; ?>>
							<img src="https://img.icons8.com/plasticine/2x/resume.png" width="200px"  height="200px">
						</a>
						<div class="form-check ">
							<input class="form-check-input" type="checkbox" name="changeResume" id="changeResume" value="true">
							<label class="form-check-label" for="changeResume">Change Resume ?</label>
						  </div>
						  <div class="imagebox-center">
				 <input type="file" name="resume"   accept="application/pdf" onchange="setResume(this)">
				 <div class="alert alert-success text-center" role="alert" id="resume_available" <?php 
					if($resume_link == "#") echo 'hidden';
					?>>
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
            <div class="row">
                       <div class="text-center">
                        <button type="submit" name="upload" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-primary">Clear</button>
                       </div>
                    </div>      
                      </form>
                </div>
   
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
