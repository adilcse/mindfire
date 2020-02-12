   <!-- this class contain all the components needs to show on the post page -->
        <?php  
            class viewPosts{
                //userId is used to track user posts and likes.
                private $userId;
                public function __construct($userId){
                    $this->userId = $userId;                 
                }
                //it shows the posts padded to this function
                public function showPosts($post){
                    $posts='';
                    foreach($post as $value){
                        $likeClass='';
                       
                        switch($value['like']){
                            case "liked":
                                $likeClass = 'text-primary';
                                
                            break;
                            case "none":
                                $likeClass='';
                             
                            break;
                            default:
                                $likeClass='';
                        }
                        $comments='';
                        foreach($value['comments'] as $comment){
                            $comments .='
                            <p>
                            '.$comment["text"].' <br>
                            <span class="text-muted">by '.$comment["by"].'
                            </p>
                            ';
                        }
                        $posts.= '
                        <div class="card ">
                        <div class="card-body">
                            <h5 class="card-title">'.$value["title"].'<h6 class="text-muted"> by '.$value["by"].'</h6></h5>

                           
                            <p class="card-text">'.$value["body"].'</p>
                            <h3><i onclick="myFunction(this,\''.$likeClass.'\',\''.$value['like'].'\',\''.$value['id'].'\',\''.$this->userId.'\')" class="fa fa-thumbs-up '.$likeClass.' "></i> </h3> 
                            <div class="form-group">
                            <label class="text-secondary font-weight-bold border-bottom" for="comment">Comments</label>
                            <div>
                            '.$comments.'
                            </div>
                            <textarea  class="form-control" id="comment" name="comment" row="2"></textarea>
                            <button type="button" class="btn btn-secondary mt-2">Comment</button>
                        </div>
                        </div>
                     </div>
                   ' ;
                    }
                   return $posts;

                }

                public function addPost(){
                    return '
                    <form action="controller.php" method="post">
                    <div class="card post">
                    <input type="hidden" name="addPost" value="true"/>
                    <div class="form-group">
                        <label for="username">Post Title</label>
                        <input type="text" class="form-control" id="title" name="title" >
                    </div>
                    <div class="form-group">
                        <label for="post">POST</label>
                        <textarea class="form-control" id="post" name="body" rows="3"></textarea>
                    </div>
                    <div class="mt-3">
                    <input
                   
                    <input type="submit" class="btn btn-primary" value="Post">
                    
                    <button type="button" class="btn btn-primary">Clear</button> 
                </div> 
               
                </div>
                </form>
                    ';
                }
            }
        ?>
        
        
     
        