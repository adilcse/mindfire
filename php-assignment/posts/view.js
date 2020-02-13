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
function addComment(commentArea,postId) {
    let  area=$(commentArea).parent();
    let newcomments=area.children(".comments").attr("hidden",false);
    let comment =area.children("textarea").val(); 
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
                console.log(result);
                area.children("textarea").val('');
                var txt = $("<p></p>").text(comment);
                var span=$("<span></span>").text("by "+result.name);
                span.addClass("text-secondary");
                newcomments.append(txt,span);  
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