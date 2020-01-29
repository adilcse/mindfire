<?php
include('dbConnectpdo.php');
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
        session_destroy();
    header("Location: /login.php"); 
    }
    
    function set_validity($errvalue,$type="true"){
        $_SESSION["profile-error"]=$type;
        $_SESSION["profile-msg"]=$errvalue;
        header("Location: /profiledb/profile.php");
       
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
        $DBConnector = DataBaseConnecter::getInstance();
        $name=$_POST['name'];
        $age=$_POST['age'];
        $email=$_POST['email'];
        $sex=$_POST['gender'];
        $mobile=$_POST['mobileno'];
        $userid=$_SESSION['uid'];
        $stateId=intval($_POST['state']);
        $fullName=explode(" ",$name,2);
        $fName=$fullName[0];
        $lName=$fullName[1];
        //check user exist or not 
        $table="users";
        $columns=["id"];     
        $con = ["id"=>$userid];
        $lmt = "LIMIT 1";
        $resultAll = $DBConnector->selectFromMysql($table,$columns,$con,$lmt);  
        
         if($row = $resultAll[0]) {
            //update users table
             $table ="users";
             $columns = ["first_name"=>$fName,"last_name"=>$lName,"age"=>$age,"email"=>$email,"mobile_number"=>$mobile,"sex"=>$sex,"state_id"=>$stateId];
             $con = ["id"=>$userid];
            $result = $DBConnector->updateMysql($table,$columns,$con);
           
           if ($result) {          
               updateSkills();
            set_validity("Successfully updated","false");
            } else {
             
                set_validity( "Not updated");
                
            }
        }
        else{
            die("error");
        // insert data into user table
            $table="users";
            $cols=["id","prefix","first_name","age","email","mobile_number","sex","state_id","created_on"];
            $vals=['$userid','Mr','$name','$age','$email','$mobile','$sex','$stateId','NOW()'];
            if ($DBConnector->insertIntoMysql($table,$cols,$vals)) {
               updateSkills();
            set_validity("Successfully updated","false");
            } else {
                set_validity($DBConnector->getConnect()->error);
                
            }
        }
    }  

     function updateSkills()
    {
        $DBConnector = DataBaseConnecter::getInstance();
        $userid=$_SESSION['uid'];
        $table="user_skills";
        $columns=["skill_id"];
        $condition=["user_id"=>$userid];
         $total_skills_aray =  $DBConnector->selectFromMysql($table,$columns,$condition);
        
         $total_skill=[];
          foreach($total_skills_aray as $skl){
             array_push($total_skill,$skl['skill_id']);
             
          }
         
         $skills= $_POST["skills"];
         $un_selected=array_diff($total_skill,$skills);
         $new_selected = array_diff($skills,$total_skill);
         foreach($new_selected as $skill){ 
         $table="user_skills";
         $cols= ["user_id","skill_id"];
         $values=[$userid,$skill];
         if(!$DBConnector->insertIntoMysql($table,$cols,$values)){
             set_validity("skills can't be added");

         }         
           
         }
         foreach($un_selected as $skill){
          $table="user_skills";
          $con= ["user_id"=>$userid,"skill_id"=>$skill];
          if(!$DBConnector->deleteFromMysql($table,$con)){
              set_validity("skills can't be deleted.");
          }
            
         }
        
    }
    function verifyImage(){
        $DBConnector = DataBaseConnecter::getInstance(); 
      
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
                $image_name = substr($_FILES["avatar"]["tmp_name"],strripos($_FILES["avatar"]["tmp_name"],"/")+1);
                $image_address = "/profileImages/".$image_name;
                $target = "..".$image_address;
         
                $table = "users";
                $cols=["image_address"];
                $con=["id"=>$_SESSION['uid']];
                $resultAll = $DBConnector->selectFromMysql($table,$cols,$con);
                $result = $resultAll[0];
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target)) {
                    unlink("..".$result['image_address']); 
                    $table="users";
                    $cols=["image_address"=>$image_address];
                    $con=["id"=>$_SESSION['uid']];
                
                    if ($DBConnector->updateMysql($table,$cols,$con)) { 
                        return true;
                    }
                    else{
                       set_validity("problem in image uploading.");
                       return false;
                    }            
                } else {
                   
                   set_validity("problem in uploading.");
                   return false;
                }
            }

            
        }else{
            return false;
        }
    }

    function verifyResume(){
        $DBConnector = DataBaseConnecter::getInstance(); 
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

                //mysql
                $resume_name = substr($_FILES["resume"]["tmp_name"],strripos($_FILES["resume"]["tmp_name"],"/")+1);
                $resume_address = "/profileResume/".$resume_name;
                $target = "..".$resume_address;
                $table = "users";
                $cols=["resume_address"];
                $con=["id"=>$_SESSION['uid']];
                $resultAll = $DBConnector->selectFromMysql($table,$cols,$con);
                $result = $resultAll[0];
              
                if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target)) {
                    unlink("..".$result['resume_address']); 
                    $table="users";
                    $cols=["resume_address"=>$resume_address];
                    $con=["id"=>$_SESSION['uid']];
                
                    if ($DBConnector->updateMysql($table,$cols,$con)) { 
                        return true;
                    }
                    else{
                       set_validity("problem in resume uploading.");
                       return false;
                    }            
                } else {
                   
                   set_validity("problem in uploading.");
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