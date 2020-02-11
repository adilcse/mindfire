<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="view.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>profile</title>
		<?php
			session_start();
			$post="active";
		?>
	</head>
	<body>
        <?php 
            include("../header/header.php");
          //  include('dbConnectpdo.php');
            class viewPosts{
               private $post= array(
                    array("title"=>"Card Title","body"=>"Some quick example text to build on the card title and make up the bulk of the card's content."),
                    array("title"=>"Card Title","body"=>"Some quick example text to build on the card title and make up the bulk of the card's content."),
                    array("title"=>"Card Title","body"=>"Some quick example text to build on the card title and make up the bulk of the card's content.")
                );

                public function showPosts(){
                    $post = $this->post;
                    foreach($post as $value){
                        echo '
                        <div class="card ">
                        <div class="card-body">
                            <h5 class="card-title">'.$value["title"].'</h5>
                           
                            <p class="card-text">'.$value["body"].'</p>
                            <h3><i onclick="myFunction(this)" class="fa fa-thumbs-up"></i> </h3> 
                            <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea  class="form-control" id="comment" name="comment" row="2"></textarea>
                            <button type="button" class="btn btn-secondary mt-2">Comment</button>
                        </div>
                        </div>
                     </div>
                   ' ;
                    }
                   

                }
            }
        ?>
         <div class ="container">
         <div class="card post">
            <div class="form-group">
                <label for="username">Post Title</label>
                <input type="text" class="form-control" id="title" name="title" >
            </div>
            <div class="form-group">
                <label for="post">POST</label>
                <textarea class="form-control" id="post" rows="3"></textarea>
            </div>
            <div class="mt-3">
            <button type="button" class="btn btn-primary">Post</button>
            <button type="button" class="btn btn-primary">Clear</button> 
        </div> 
        </div>
        <?php
            $post = new viewPosts();
            $post->showPosts(); 
            ?>
         </div>
         <script>
             function myFunction(x) {
  x.classList.toggle("fa-thumbs-down");
}
         </script>    
    </body>
</html>