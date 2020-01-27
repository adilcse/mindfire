<?php
    include("../profiledb/dbConnectpdo.php");
    $username="example";
    $password="testing";
    $password_hash=password_hash($password, PASSWORD_DEFAULT);
   
    $sql="INSERT INTO user_credentials(user_name,password) VALUES('$username','$password_hash');";
    $stmt=$conn->prepare($sql);
   if($stmt->execute())
    {
        echo "added successfully.";

    }
    else{
        echo "running";
        echo $conn->error;
    }
?>