<?php
  include_once('view.php');
  include_once('model.php');  
   session_start();
  
    class controller{
        private $userId;
        private $model;
        private $viewPost;
        public function __construct($uid)
        {
            $this->userId=$uid;
            $this->model = new model();
            $this->viewPost = new viewPosts($uid);

           
           
        }
        public  function setViewPage(){
            echo $this->viewPost->addPost();
            $posts = $this->getPosts(5);
           echo $this->viewPost->showPosts($posts);
          ///  var_dump($posts);
            // var_dump($this->getComments(104,5));

        }
        public function setPost($post)
        {
            //  $post = array('title'=>"First Post",'body'=>"this is my new post in this website, please like it for amazing posts");
            return $result =$this->model->setPost($post,$this->userId);
           
        }
        public function getPosts($limit)
        {
            $posts = $this->model->getAllPosts($limit,$this->userId); 
            return $posts;  
        }
        public function getComments($postId,$limit){
            return $this->model->getComments($postId,$limit);
        }
        public function addComment($comment,$postId)
        {
            $status=$this->model->addComment($comment,$postId,$this->userId);
            if($status){
                return ["success"=>true,"name"=>$_SESSION['name'],"value"=>$status];
            }else{
                return ["success"=>false];
            }            
        }
        //Add like to a post
        public function addLike($postId)
        {
         return $this->model->addLike($postId,$this->userId);   
        }
        public function removeLike($postId)
        {
         return $this->model->removeLike($postId,$this->userId);   
        }
    }
        //    $posts= array(
        //     array("id"=>"123","title"=>"Card Title","by"=>"Addd","body"=>"Some quick example text to build on the card title and make up the bulk of the card's content.","like"=>"liked","comments"=>array(array("text"=>"owsome design","by"=>"adil"),array("text"=>"owsome design","by"=>"adil"),array("text"=>"owsome design","by"=>"adil"))),
        //     array("id"=>"12","title"=>"Card Title","by"=>"Addd","body"=>"Some quick example text to build on the card title and make up the bulk of the card's content.","like"=>"liked","comments"=>array(array("text"=>"owsome design","by"=>"adil"),array("text"=>"owsome design","by"=>"adil"),array("text"=>"owsome design","by"=>"adil"))),
        //     array("id"=>"123","title"=>"Card Title","by"=>"Addd","body"=>"Some quick example text to build on the card title and make up the bulk of the card's content.","like"=>"none","comments"=>array(array("text"=>"owsome design","by"=>"adil"),array("text"=>"owsome design","by"=>"adil"),array("text"=>"owsome design","by"=>"adil")))
        //    );
        //     $post = new viewPosts("1234");
           
        //     echo $post->addPost();
        //     echo $post->showPosts($posts,true); 

        $controller=new controller($_SESSION['uid']);
        if(isset($_POST['getComment'])&& $_POST['getComment']==='true'){
            $postId=$_POST['getPostId'];
            $comments = $controller->getComments($postId,5);
            
            echo json_encode($comments);
            die;
        }
        if(isset($_POST['addComment'])&& $_POST['addComment']==='true'){
            $status = $controller->addComment($_POST['comment'],$_POST['postId']);
            echo json_encode($status);
            die;
        }
        if(isset( $_POST['addPost'])&& $_POST['addPost']==='true'){
            $post =array('title'=>$_POST['title'],'body'=>$_POST['body']);
            if(isset($_POST['title'])&& isset($_POST['body']))
                $controller->setPost($post);
                header("Location: /posts/view.php"); 
                die;
         }
         if(isset($_POST['addLike'])&& $_POST['addLike']==='true'){
             if($_POST['likeValue']=='true'){
                 $result =$controller->addLike($_POST['postId']);
                     echo json_encode(["result"=>$result]);
             }else if($_POST['likeValue']=='false'){
                $result =$controller->removeLike($_POST['postId']);
                echo json_encode(["removed"=>$result]);
             }
             die;
         }
        include_once('viewHeader.php');
        $controller->setViewPage();
    include_once('viewFooter.php');
            ?>