<?php
include('../databaseConnect.php');
session_start();
    if(!empty($_POST)){
        ini_set('display_errors', 1);

        $skills=$_POST["skills"];
        if(count($skills)<2){
           set_validity("enter atleast 2 skills");
            exit();
        }else{
            if(!empty($_POST["changeImage"]) && $_POST["changeImage"]=="true"){
                if(verifyImage())
                    {
                        addToDb();
                    }
                else{
                    set_validity("invalid image.");
                } 
            }
            elseif(!empty($_POST["changeResume"])){
                if(verifyResume())
                {
                    addToDb();
                }
            }
             else 
                  addToDb();
        }
    }else{
        set_validity("profile","edit");
    }
    
    function set_validity($errvalue,$type="true"){
        header("Location: /profiledb/profile.php?error=".$type."&msg=".$errvalue);
        exit(); 
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return input_validate($data);
      }
    function input_validate($data){
        if(strlen($data)<3){
            return false;
        }
        else{
            return $data;
        }

    }  
    function addToDb(){
        include('../databaseConnect.php');
        $name=$_POST['name'];
        $age=$_POST['age'];
        $email=$_POST['email'];
        $sex=$_POST['gender'];
        $mobile=$_POST['mobileno'];
        $state=$_POST['state'];
        $userid=$_SESSION['uid'];
        $stateId=intval($_POST['state']);
        //check user exist or not
        $sql="SELECT id FROM users where id = '$userid ' LIMIT 1;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
           $sql="UPDATE TABLE users SET first_name='$name',
                                        age=$age,
                                        email='$email',
                                        mobile_number='$mobile',
                                        sex='$sex',
                                        state_id=$stateId
                                        WHERE id= '$userid';";
             if ($conn->query($sql) === TRUE) {
                //update skill table
            set_validity("Successfully updated","false");
            } else {
                set_validity( $conn->error);
                
            }
         }

        } else{
            die($conn->error);
        // update user table
            $sql="INSERT INTO users(id,prefix,first_name,age,email,mobile_number,sex,state_id,created_on) VALUES
            ('$userid','Mr','$name',$age,'$email','$mobile','$sex',$stateId,NOW());
            ";
            if ($conn->query($sql) === TRUE) {
                //update skill table
            set_validity("Successfully updated","false");
            } else {
                set_validity( $conn->error);
                
            }
        }
    }  


    function verifyImage(){
       

        if(isset($_POST["upload"])){
            $allowed_image_extension = array(
                "png",
                "jpg",
                "jpeg" ,
                "JPEG" 
            );
            $filename=$_FILES["avatar"]["name"];
           
         
            $tempname= $_SESSION["username"];
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
          
            if (!file_exists($_FILES["avatar"]["tmp_name"])) {
                set_validity("Please upload only png or jpg file.");
               return false;
            } 
            else if (! in_array($file_extension, $allowed_image_extension)){
                set_validity("invalid image type.");
                return false;
            }
            else if (($_FILES["avatar"]["size"] > 1024*1024 )) {
                set_validity("file should be less them 1MB.");
                return false;
               
            }  
            else {
                $target = "../profileImages/" .$_FILES["avatar"]["tmp_name"];
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target)) {
                    setcookie("image",$_FILES["avatar"]["tmp_name"], time() + (86400 * 30), "/");
                    return true;
                } else {
                    echo "error";
                    exit();
                   set_validity("problem in uploading.");
                   return false;
                }
            }

            
        }else{
            return false;
        }
    }

    function verifyResume(){
        if(isset($_POST["upload"])){
            $allowed_image_extension = array(
                "pdf",
                "PDF"
            );
            $filename=$_FILES["resume"]["name"];
           
         
            $tempname= $_SESSION["username"];
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
          
            if (!file_exists($_FILES["resume"]["tmp_name"])) {
                set_validity("Please upload only pdf file.");
               return false;
            } 
            else if (! in_array($file_extension, $allowed_image_extension)){
                set_validity("invalid document type.");
                return false;
            }
            else if (($_FILES["resume"]["size"] > 1024*1024*2 )) {
                set_validity("file size should be less them 2MB.");
                return false;
               
            }  
            else {
                $target = "../profileResume/" . basename($tempname);
                if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target)) {
                    setcookie("resume",basename($tempname), time() + (86400 * 30), "/");
                    return true;
                } else {
                    echo "error";
                    exit();
                   set_validity("problem in uploading document.");
                   return false;
                }
            }
        }
            else{
                set_validity("Something went wrong.");
                return false;

            }
        }
    

?>