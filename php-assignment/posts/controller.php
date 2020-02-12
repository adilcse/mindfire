<?php
    include_once('viewHeader.php');
    include_once('view.php');
    include_once('model.php');  
    class controller{
        private $userId;
        private $model;
        private $viewPost;
        public function __construct($uid)
        {
            $this->userId=$uid;
            $this->model = new model();
            $this->viewPost = new viewPosts($userId);
           
           
        }
        public  function setViewPage(){
            echo $this->viewPost->addPost();
            echo $this->getPosts(5);
        }
        public function setPost($post)
        {
            //  $post = array('title'=>"First Post",'body'=>"this is my new post in this website, please like it for amazing posts");
            return $result =$this->model->setPost($post,$this->userId);
           
        }
        public function getPosts($limit)
        {
            $posts = $this->model->getAllPosts($limit);
            return $posts;
           
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
        if($_POST['addPost']=='true'){
           $post =array('title'=>$_POST['title'],'body'=>$_POST['body']);
           echo $controller->setPost($post);
        }
        $controller->setViewPage();
    include_once('viewFooter.php');
            ?>