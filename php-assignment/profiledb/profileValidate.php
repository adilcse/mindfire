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
        $conn -> close();
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
        $userid=$_SESSION['uid'];
        $stateId=intval($_POST['state']);
        
        //check user exist or not
        $sql="SELECT id FROM users where id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s",$userid);
        $stmt->execute();   
       $result = $stmt->get_result();
        if ($result->num_rows > 0) {

         while($row = $result->fetch_assoc()) {
            
           $sql="UPDATE users SET first_name=?, age=?, email=?, mobile_number=?,sex=?,state_id=? WHERE id = ?;";
           $stmt = $conn->prepare($sql);
           $stmt->bind_param("sisssii",$name,$age,$email,$mobile,$sex,$stateId,$userid); 
           if ($stmt->execute() === TRUE) { 
               //select total skills available
               $total_skills_aray = $conn->query("SELECT skill_id FROM user_skills WHERE user_id = $userid");
               $total_skill=[];
                while($skl = $total_skills_aray->fetch_assoc()){
                   array_push($total_skill,$skl['skill_id']);
                }
              
                //add skill table
                $sql_insert="INSERT IGNORE INTO user_skills(user_id,skill_id) VALUES(?,?)";  
                $sql_delete="DELETE FROM user_skills WHERE user_id= ? AND skill_id = ?";  
                $stmt_insert=$conn->prepare($sql_insert);
                $stmt_delete=$conn->prepare($sql_delete);
               $skills= $_POST["skills"];
               $un_selected=array_diff($total_skill,$skills);
               $new_selected = array_diff($skills,$total_skill);
              
               foreach($new_selected as $skill){
                $stmt_insert->bind_param("ii",$userid,$skill);
                $stmt_insert->execute();     
               }
               foreach($un_selected as $skill){
                   $stmt_delete->bind_param("ii",$userid,$skill);
                   $stmt_delete->execute();
               }
             

             
            set_validity("Successfully updated","false");
            } else {
               
                set_validity( $conn->error);
                
            }
         }

        } else{
        
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
                $image_name = substr($_FILES["avatar"]["tmp_name"],strripos($_FILES["avatar"]["tmp_name"],"/")+1);
                $image_address = "/profileImages/".$image_name;
                $target = "..".$image_address;
                $sql="SELECT image_address FROM users WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i",$_SESSION['uid']);
                $stmt->execute();   
               $result = $stmt->get_result()->fetch_assoc();
              
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target)) {
                    unlink("..".$result['image_address']); 
                    $sql="UPDATE users SET image_address = ? WHERE id = ?;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si",$image_address,$_SESSION['uid']); 
                    if ($stmt->execute() === TRUE) { 
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
        include('../databaseConnect.php'); 
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
                $sql="SELECT resume_address FROM users WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i",$_SESSION['uid']);
                $stmt->execute();   
               $result = $stmt->get_result()->fetch_assoc();
              
                if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target)) {
                    unlink("..".$result['resume_address']); 
                    $sql="UPDATE users SET resume_address = ? WHERE id = ?;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si",$resume_address,$_SESSION['uid']); 
                    if ($stmt->execute() === TRUE) { 
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