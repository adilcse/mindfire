//it registers a like of a user to  a post
function likePost(likeArea,postId,value){
    let area=$(likeArea).parent().parent();
    const likeSpan=area.children("h6").children("span");
    let like=parseInt(likeSpan.text()); 
    
    if(value){
     likeSpan.text(like+1);  
    }else{
        likeSpan.text(like-1); 
    }
    console.log(like);
    const postData={
        postId:postId,
        addLike:"true",
        likeValue:value
    }
    $.ajax({
        url: "controller.php", 
        data: postData ,
        method :"POST",
        success: function(result){
           
           console.log(result)
        },
        error: function(e){
          
            console.log(e);
        }
  });
}
//when user clickes aa liad comment button then it loads the comment of a post
function loadComments(commentArea,postId){
    commentArea.innerHTML="Loading...";
    const postData={
        getPostId:postId,
        getComment:"true"
    }
    $.ajax({
        url: "controller.php", 
        data: postData ,
        method :"POST",
        success: function(result){
           
           showComment(JSON.parse(result),commentArea)
        },
        error: function(e){
            loadFailed(commentArea);
            console.log(e);
        }
  });
  //if loading of comment fails then it alerts the user
  function loadFailed(commentArea){
    let  area=$(commentArea).parent();
    area.children("#showCommentText").text("try again...");
    area.children(".comments").attr("hidden",true);
  }

  //shows the comment of selected post
  function showComment(result,commentArea){
  let  area=$(commentArea).parent();
   area.children("#showCommentText").attr("hidden",true);
   let newcomments=area.children(".comments").attr("hidden",false);
   console.log(result);
    result.forEach(element => {
        var txt = $("<p></p>").text(element.comment);
        var span=$("<span></span>").text("by "+element.name);
        span.addClass("text-secondary");
        newcomments.prepend(txt,span);

   
        });
        if(result.length === 0){
            var txt = $("<p></p>").text("be the first one to comment");
            txt.addClass("text-secondary");
            newcomments.append(txt);
        }
   
 

  }
    //console.log(postId);
}
//when user adds a comments it saves the comment of the user.
function addComment(commentArea,postId) {
    let  area=$(commentArea).parent();
    let comment =area.children("textarea").val(); 
    if(comment.length<3){
        area.children("textarea").addClass("is-invalid");
        return;
    }else{
        area.children("textarea").addClass("is-valid");
    }
   let newcomments =area.children(".comments").attr("hidden",false);
    let postData = {
        addComment:"true",
        comment:comment,
        postId :postId,
        
    }
    $.ajax({
        url: "controller.php", 
        data: postData ,
        method :"POST",
        success: function(result){
            result=JSON.parse(result);
            if(result.success)
            { 
                area.children("textarea").removeClass("is-valid");
                console.log(result);
                area.children("textarea").val('');
                var txt = $("<p></p>").text(comment);
                var span=$("<span></span>").text("by "+result.name);
                span.addClass("text-secondary");
                newcomments.append(txt,span);
               // loadComments(commentArea,postId);

            }else{
                console.log(result);
            }
         
        },
        error: function(e){
           
            console.log(e);
        }
  });
    console.log();
}
function myFunction(x,liked,id) {
if(liked==='text-secondary'){
    x.setAttribute("onclick","myFunction(this,'text-primary',"+id+")");
    x.classList.add("text-primary");
    x.classList.remove("text-secondary");
   
    likePost(x,id,true);
    return;
}
else if(liked==="text-primary"){
   
    x.setAttribute("onclick","myFunction(this,'text-secondary',"+id+")");
    x.classList.add("text-secondary");
    x.classList.remove("text-primary");
   
    likePost(x,id,false);
    return;
}
}
window.onload = function(){
    $( "#addPost" ).submit(function( event ) {
        let title=$("#title").val();
        let post=$("#post").val();
       console.log(title,post);
       if(title.length < 3){
        $("#title").addClass("is-invalid");

       }else if(post.length <3){
        $("#post").addClass("is-invalid");
        $("#title").removeClass("is-invalid") 
        $("#title").addClass("is-valid");
       }
       else{
        $("#post").removeClass("is-invalid") ;
        $("#title").removeClass("is-invalid") 
        $("#post").addClass("is-valid");
        $("#title").addClass("is-valid");
        return;
       }
        event.preventDefault();

      });
}
