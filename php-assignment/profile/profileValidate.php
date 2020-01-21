<?php

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
                        set_all_cookie();
                    }
                else{
                    set_validity("invalid image.");
                } 
            }
            elseif($_POST["changeResume"]=="true"){
                if(verifyResume())
                {
                    set_all_cookie();
                }
            }
             else 
                  set_all_cookie();
        }
    }else{
        set_validity("profile","edit");
    }
    
    function set_validity($errvalue,$type="true"){
        header("Location: /profile/profile.php?error=".$type."&msg=".$errvalue);
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
    function set_all_cookie(){
        setcookie("username", $_SESSION["username"], time() + (86400 * 30), "/");
        $name=test_input($_POST["name"]);
        if(!$name){
            set_validity("enter valid name");
        }else
             setcookie("name", $name, time() + (86400 * 30), "/");
        $email=test_input($_POST["email"]);
        setcookie("email", $email, time() + (86400 * 30), "/");
        $mobileno=test_input($_POST["mobileno"]);
        setcookie("mobilenumber", $mobileno, time() + (86400 * 30), "/");
        $age= $_POST["age"];
        setcookie("age", $age, time() + (86400 * 30), "/");
        $gender=$_POST["gender"];
        if($gender == 'male' || $gender== 'female')
            setcookie("gender", $gender, time() + (86400 * 30), "/");
        else
            set_validity("enter valid gender");
        $state=test_input($_POST["state"]);
        setcookie("state", $state, time() + (86400 * 30), "/");
        $skills=$_POST["skills"];
        setcookie("skills",serialize($skills), time() + (86400 * 30), "/");
        set_validity("updated successfully.","false");
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
                $target = "../profileImages/" . basename($tempname);
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target)) {
                    setcookie("image",basename($tempname), time() + (86400 * 30), "/");
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