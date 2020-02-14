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
    public function getAllPosts($limit,$userId)
    {
      //  SELECT posts.id as id, users.first_name as name, posts.title, posts.body,
      //COUNT(likes.user_id) as likes FROM posts INNER JOIN users ON posts.user_id = users.id 
      //LEFT JOIN likes ON posts.id=likes.post_id GROUP BY posts.id  
      //ORDER BY posts.created_on DESC  LIMIT 5;

         
        $table = 'posts';
        $columns = ['posts.id as id','users.first_name as name','posts.title','posts.body','COUNT(likes.user_id) as likes'];
        $joinType=['JOIN','LEFT JOIN'];
        $onCondition=['posts.user_id'=>'users.id','posts.id'=>'likes.post_id'];
        $joinTable=["users","likes"];
        $whereCondition=["true"=>"true"];
        $lmt="GROUP BY posts.id ORDER BY posts.created_on DESC LIMIT ".$limit;

        $resultAll = $this->DBConnector->selectFromMysqlJoin($table,$columns,$joinType,$joinTable,$onCondition,$whereCondition,$lmt);
        
        //get user likes
        $table="likes";
        $columns=["post_id"];
        $whereCondition = ["user_id"=>$userId];
        $result = $this->DBConnector->selectFromMysql($table,$columns,$whereCondition);
        $likes=[];
        foreach($result as $value){
            array_push($likes,$value['post_id']);
        }
        $posts=[];
        foreach($resultAll as $key=>$post){
          
            if(in_array($post['id'],$likes)){
               $post = array_merge($post,["liked"=>true]);
            }    
            else{
               $post = array_merge($post,["liked"=>false]);    
            }             
            array_push($posts,$post);
        }

        return $posts;
       // return $resultAll;
        # code...
    }
    public function getComments($postId,$limit)
    {
        $table = 'comments';
        $columns = ['users.first_name as name','comments.comment'];
        $joinType=['INNER JOIN'];
        $onCondition=['comments.user_id'=>'users.id'];
        $joinTable=["users"];
        $whereCondition=["post_id"=>$postId];
        
        $lmt=" ORDER BY comments.created_on DESC LIMIT ".$limit;
        $resultAll = $this->DBConnector->selectFromMysqlJoin($table,$columns,$joinType,$joinTable,$onCondition,$whereCondition,$lmt);
        
        return $resultAll;
    }
    public function addComment($comment,$postId,$userId){
        $table="comments";
        $columns=['post_id','comment','user_id'];
        $values = [$postId,$comment,$userId];
        if($this->DBConnector->insertIntoMysql($table,$columns,$values)){
            return true;
        }
        else{
            return false;
        }
    }
    public function addLike($postId,$userId)
    {
       $table="likes";
       $columns=["post_id","user_id"];
       $values = [$postId,$userId];
       $res =$this->DBConnector->insertIntoMysql($table,$columns,$values);
        return $res;
       if($res){
        return true;
    }
    else{
        return false;
    }
    }
    public function removeLike($postId,$userId)
    {
       $table="likes";
       $condition=["post_id"=>$postId,"user_id"=>$userId];
       return $result=$this->DBConnector->deleteFromMysql($table,$condition); 
       if($result){
        return true;
    }
    else{
        return false;
    }
    }
   
}