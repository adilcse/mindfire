<?php
    include("../profiledb/dbConnectpdo.php");
    $username="adil";
    $password="mindfire";
    $password_hash=password_hash($password, PASSWORD_DEFAULT);
   
   
   if($DBConnector->insertIntoMysql("user_credentials",["user_name","password"],[$username,$password_hash]))
    {
        echo "added successfully.";

    }
    else{
        echo "failed";
        echo $conn->error;
    }
?>