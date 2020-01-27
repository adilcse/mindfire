<?php
    include("databaseConnect.php");
    $username="example";
    $password="testing";
    $password_hash=password_hash($password, PASSWORD_DEFAULT);
    $sql="INSERT INTO user_credentials(user_name,password) VALUES('$username','$password_hash');";
    if($conn->query($sql) === TRUE){
        echo "added successfully.";

    }
    else{
        echo $conn->error;
    }
?>