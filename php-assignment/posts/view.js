function likePost(userId,postId,value){
    console.log(userId,postId,value);
}
function myFunction(x,liked,like,id,userId) {
if(like==='none'){
    x.setAttribute("onclick","myFunction(this,'text-primary','liked','"+id+"','"+userId+"')");
    x.classList.add("text-primary");
   // x.classList.toggle(liked);
   
    likePost(userId,id,true);
    return;
}
else if(like==="liked"){
   
    x.setAttribute("onclick","myFunction(this,'"+liked+"','none','"+id+"','"+userId+"')");
    x.classList.toggle(liked);
    likePost(userId,id,false);
    return;
}

               
 

}