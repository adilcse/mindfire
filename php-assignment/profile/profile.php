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
    $skills=unserialize($_COOKIE['skills']);
    $img="https://banner2.cleanpng.com/20180521/ocp/kisspng-computer-icons-user-profile-avatar-french-people-5b0365e4f1ce65.9760504415269493489905.jpg";
    $java=$c=$html=$python=$css='';
    foreach($skills as $skill){
        switch($skill){
            case 'java':
                $java = 'checked';
            break;
            case 'c':
                $c = 'checked';
            break;
            case 'html':
                $html = 'checked';
            break;
            case 'python':
                $python = 'checked';
            break;
            case 'css':
                $css = 'checked';
            break;
        }
    }
    ?>
    <div class="profile-body">
        <div class="container">
         
                <?php
                    if($_GET['error']=='true')
                    {
                        echo ' <div class="alert alert-danger text-center" role="alert">
                        '.$_GET["msg"].' </div>';
                    }else if($_GET['error']=='false'){
                        echo ' <div class="alert alert-success text-center" role="alert">
                        '.$_GET["msg"].' </div>';
                    }
                ?>
           
              
           
            <div class="row">
               
                    <form method="POST" action="profileValidate.php">
                        <div class="row">
                        <div class="col-md-8">
                        <div class="form-group">
                            <label for="username">User name</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username?>" disabled>
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
                                    <input class="form-check-input" type="radio" name="gender" id="gender-m" value="male" checked <?php if($_COOKIE['gender']=='male') echo 'checked'; ?>>
                                    <label class="form-check-label" for="gender-m">
                                      Male
                                    </label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender-f" value="female" <?php if($_COOKIE['gender']=='female') echo 'checked'; ?>>
                                    <label class="form-check-label" for="gender-f">
                                     Female
                                    </label>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <label for="validationCustom04">State</label>
                            <select class="custom-select" id="validationCustom04" name="state" required>
                              <option selected disabled value="">Choose...</option>
                              <option value="Andhra Pradesh" <?php if($_COOKIE['state']=='Andhra Pradesh') echo 'selected'; ?>>Andhra Pradesh</option>
                              <option value="Andaman and Nicobar Islands" <?php if($_COOKIE['state']=='Andaman and Nicobar Islands') echo 'selected'; ?>>Andaman and Nicobar Islands</option>
                              <option value="Arunachal Pradesh"<?php if($_COOKIE['state']=='Arunachal Pradesh') echo 'selected'; ?> >Arunachal Pradesh</option>
                              <option value="Assam" <?php if($_COOKIE['state']=='Assam') echo 'selected'; ?>>Assam</option>
                              <option value="Bihar" <?php if($_COOKIE['state']=='Bihar') echo 'selected'; ?>>Bihar</option>
                              <option value="Chandigarh" <?php if($_COOKIE['state']=='Chandigarh') echo 'selected'; ?>>Chandigarh</option>
                              <option value="Chhattisgarh" <?php if($_COOKIE['state']=='Chhattisgarh') echo 'selected'; ?>>Chhattisgarh</option>
                              <option value="Dadar and Nagar Haveli" <?php if($_COOKIE['state']=='Dadar and Nagar Haveli') echo 'selected'; ?>>Dadar and Nagar Haveli</option>
                              <option value="Daman and Diu" <?php if($_COOKIE['state']=='Daman and Diu') echo 'selected'; ?>>Daman and Diu</option>
                              <option value="Delhi" <?php if($_COOKIE['state']=='Delhi') echo 'selected'; ?>>Delhi</option>
                              <option value="Lakshadweep" <?php if($_COOKIE['state']=='Lakshadweep') echo 'selected'; ?>>Lakshadweep</option>
                              <option value="Puducherry" <?php if($_COOKIE['state']=='Puducherry') echo 'selected'; ?>>Puducherry</option>
                              <option value="Goa" <?php if($_COOKIE['state']=='Goa') echo 'selected'; ?>>Goa</option>
                              <option value="Gujarat" <?php if($_COOKIE['state']=='Gujarat') echo 'selected'; ?>>Gujarat</option>
                              <option value="Haryana" <?php if($_COOKIE['state']=='Haryana') echo 'selected'; ?>>Haryana</option>
                              <option value="Himachal Pradesh" <?php if($_COOKIE['state']=='Himachal Pradesh') echo 'selected'; ?>>Himachal Pradesh</option>
                              <option value="Jammu and Kashmir" <?php if($_COOKIE['state']=='Jammu and Kashmir') echo 'selected'; ?>>Jammu and Kashmir</option>
                              <option value="Jharkhand" <?php if($_COOKIE['state']=='Jharkhand') echo 'selected'; ?>>Jharkhand</option>
                              <option value="Karnataka" <?php if($_COOKIE['state']=='Karnataka') echo 'selected'; ?>>Karnataka</option>
                              <option value="Kerala" <?php if($_COOKIE['state']=='Kerala') echo 'selected'; ?>>Kerala</option>
                              <option value="Madhya Pradesh" <?php if($_COOKIE['state']=='Madhya Pradesh') echo 'selected'; ?>>Madhya Pradesh</option>
                              <option value="Maharashtra" <?php if($_COOKIE['state']=='Maharashtra') echo 'selected'; ?>>Maharashtra</option>
                              <option value="Manipur" <?php if($_COOKIE['state']=='Manipur') echo 'selected'; ?>>Manipur</option>
                              <option value="Meghalaya" <?php if($_COOKIE['state']=='Meghalaya') echo 'selected'; ?>>Meghalaya</option>
                              <option value="Mizoram" <?php if($_COOKIE['state']=='Mizoram') echo 'selected'; ?>>Mizoram</option>
                              <option value="Nagaland" <?php if($_COOKIE['state']=='Nagaland') echo 'selected'; ?>>Nagaland</option>
                              <option value="Odisha" <?php if($_COOKIE['state']=='Odisha') echo 'selected'; ?>>Odisha</option>
                              <option value="Punjab" <?php if($_COOKIE['state']=='Punjab') echo 'selected'; ?>>Punjab</option>
                              <option value="Rajasthan" <?php if($_COOKIE['state']=='Rajasthan') echo 'selected'; ?>>Rajasthan</option>
                              <option value="Sikkim" <?php if($_COOKIE['state']=='Sikkim') echo 'selected'; ?>>Sikkim</option>
                              <option value="Tamil Nadu" <?php if($_COOKIE['state']=='Tamil Nadu') echo 'selected'; ?>>Tamil Nadu</option>
                              <option value="Telangana" <?php if($_COOKIE['state']=='Telangana') echo 'selected'; ?>>Telangana</option>
                              <option value="Tripura" <?php if($_COOKIE['state']=='Tripura') echo 'selected'; ?>>Tripura</option>
                              <option value="Uttar Pradesh" <?php if($_COOKIE['state']=='Uttar Pradesh') echo 'selected'; ?>>Uttar Pradesh</option>
                              <option value="Uttarakhand" <?php if($_COOKIE['state']=='Uttarakhand') echo 'selected'; ?>>Uttarakhand</option>
                              <option value="West Bengal" <?php if($_COOKIE['state']=='West Bengal') echo 'selected'; ?>>West Bengal</option>
                            </select>
                            <div class="invalid-feedback">
                              Please select a valid state.
                            </div>
                          </div>
                          <div class="">
                            <label >Skills</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="skills[]" id="java" value="java" <?php echo $java?>>
                                <label class="form-check-label" for="java">Java</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="skills[]" id="c" value="c/c++" <?php echo $c?>>
                                <label class="form-check-label" for="c">C / C++</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="skills[]" id="python" value="python" <?php echo $python?>>
                                <label class="form-check-label" for="python">Python</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="skills[]" id="html" value="html" <?php echo $html?> >
                                <label class="form-check-label" for="html">HTML</label>
                              </div>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="skills[]" id="css" value="css" <?php echo $css ?> >
                            <label class="form-check-label" for="css">CSS</label>
                          </div>
                 </div>
                 <div class="col-md-4">
                    <img src=<?php echo $img?> width="200px" height="200px" class="rounded mx-auto d-block" alt="avatar" id="profilepic">
                    Select a file: <input type="file" name="file" id="avatar" name="avatar" onchange="setphoto(this)" accept="image/png, image/jpeg">

                </div>         
            </div>
            <div class="row">
                       <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
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
          
          console.log(p.files[0]);
        
        }
     </script>   
    <?php include("../footer/footer.php");?>
</body>
</html>
