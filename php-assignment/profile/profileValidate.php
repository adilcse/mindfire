<?php
session_start();
    if(!empty($_POST)){
        $skills=$_POST["skills"];
        if(count($skills)<2){
           set_validity("enter atleast 2 skills");
            exit();
        }else{
           set_all_cookie();
        }
    }else{
        set_validity("profile","edit");
    }
    
    function set_validity($errvalue,$type="true"){
        header("Location: http://other.com/profile/profile.php?error=".$type."&msg=".$errvalue);
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

?>