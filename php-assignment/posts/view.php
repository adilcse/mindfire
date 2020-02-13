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
                                $likeClass='text-secondary';
                             
                            break;
                            default:
                                $likeClass='text-secondary';
                        }
                        $posts.= '
                        <div class="card " id=card'.$value["id"].'>
                        <div class="card-body">
                            <h5 class="card-title">'.$value["title"].'<h6 class="text-muted"> by '.$value["name"].'</h6></h5>

                           
                            <p class="card-text">'.$value["body"].'</p>
                            <div class="like">
                                <h3><i onclick="myFunction(this,\''.$likeClass.'\','.$value["id"].')" class="fa fa-thumbs-up '.$likeClass.' "></i> </h3> 
                                <h6><span>'.$value["likes"].'</span> Likes</h6>
                             </div>   
                            <div class="form-group">
                            <label class="text-secondary font-weight-bold border-bottom" for="comment">Comments</label>
                            <div class="commentArea">
                                <div id="showCommentText" class="text-secondary" onclick="loadComments(this,'.$value["id"].')">
                               <i class="fa fa-clock-o"></i>Show Comments
                                </div>
                                <div class="comments" hidden>
                                </div>
                                <textarea  class="form-control" id="comment" name="comment" row="2"></textarea>
                            <button type="button" class="btn btn-secondary mt-2" onclick=addComment(this,'.$value['id'].')>Comment</button>
                            </div>
                            
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
        
        
     
        