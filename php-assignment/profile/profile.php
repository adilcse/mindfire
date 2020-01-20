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
    <?php include("../header/header.php");?>
    <div class="profile-body">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <form>
                        <div class="form-group">
                            <label for="username">User name</label>
                            <input type="text" class="form-control" id="username" value="<?php echo $username?>" disabled>
                          </div>
                        <div class="form-group">
                          <label for="name">Your Name</label>
                          <input type="text" class="form-control" id="name" >
                         
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="name@example.com">
                          </div>
                          <div class="form-group">
                          <label class="" for="mobileno">Mobile number</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">+91</div>
                                </div>
                                <input type="text" class="form-control" id="mobileno" placeholder="mobile number" pattern="[789][0-9]{9}">
                            </div>  
                          </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="username">Age</label>
                                <input type="number" class="form-control" id="age" min="20" max="30">
                            </div>
                            <div class="form-group col-md-7 ">
                                <label for="">Gender</label><br>
                                <div class="form-check form-check-inline" >
                                    <input class="form-check-input" type="radio" name="gender" id="gender-m" value="male" checked>
                                    <label class="form-check-label" for="gender-m">
                                      Male
                                    </label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="gender-f" value="female">
                                    <label class="form-check-label" for="gender-f">
                                     Female
                                    </label>
                                  </div>
                            </div>
                        </div>
                       <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-primary">Clear</button>
                       </div>
                      </form>
                </div>
            </div>

        </div>
    </div>
    <?php include("../footer/footer.php");?>
</body>
</html>
