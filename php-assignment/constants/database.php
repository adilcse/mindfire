<?php
class Database{
    protected $servername = "myawsdatabase.cgciww58dmdb.us-east-2.rds.amazonaws.com";
    protected $username = "local";
    protected $password = "mindfire";
    protected $db = "php_profile";
    protected function getServerName(){
        return $servername;
    }
    protected function getUserName(){
        return $username;
    }
    protected function getPassword(){
        return $password;
    }
    protected function getDB(){
        return $db;
    }
}