<?php
include_once('../profiledb/dbConnectpdo.php');
class model{
    private $DBConnector;
    public function __construct()
    {
        $this->DBConnector = DataBaseConnecter::getInstance(); 
    }
     public function setPost($post,$userId)
    {
      $postTitle = $post['title'];
      $postBody = $post['body'];
      $table = 'posts';
      $columns = ['user_id','title','body'];
      $values = [$userId,$postTitle,$postBody];
      if($this->DBConnector->insertIntoMysql($table,$columns,$values)){
          return true;
      }
      else{
          return false;
      }
    }
    public function getAllPosts($limit)
    {
        $table = 'posts';
        $columns = ['users.first_name as by','posts.title','posts.body'];
        $joinType='INNER JOIN';
        $onCondition=['posts.user_id'=>'users.id'];
        $joinTable="users";
        $whereCondition=["true"=>"true"];
        $lmt=$limit;
        $resultAll = $this->DBConnector->selectFromMysqlJoin($table,$columns,$joinType,$joinTable,$onCondition,$whereCondition,$lmt);
        
        return $resultAll;
        # code...
    }

}