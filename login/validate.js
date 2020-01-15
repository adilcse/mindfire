let userLogoAdded=false;
let passwordLogoAdded=false;
let  userPasswordLogo=document.createElement("img");
userPasswordLogo.setAttribute('width','40px');
userPasswordLogo.setAttribute('height','40px');
let userStatusLogo=document.createElement("img");
userStatusLogo.setAttribute('width','40px');
userStatusLogo.setAttribute('height','40px');
let userDiv=document.getElementById("userDiv");
let pwdDiv=document.getElementById("passwordDiv");
const checkUserId=()=>{
  let uid=  document.getElementById("userName").value;
  let re = /^((?=.*[a-z])|(?=.*[A-Z]))\w{6,}$/;
  isValiduser=re.test(uid);
   if(!isValiduser){
       setInvalidUser();
       if(!userLogoAdded){
        document.getElementById('userDiv').appendChild(userStatusLogo);
        userLogoAdded=true;
       }
       return false;
    }else{
        if(!userLogoAdded){
            document.getElementById('userDiv').appendChild(userStatusLogo);
            userLogoAdded=true;
           }
            
        setValidUser();
        return true;
    }
}
const setInvalidUser=(text)=>{
       userStatusLogo.setAttribute("src","cross.png");
       userStatusLogo.setAttribute('alt','cross');
}
const setValidUser=()=>{
    userStatusLogo.setAttribute("src","tick.png");
    userStatusLogo.setAttribute("alt","tick");
  

}
const checkPassword=()=>{
 

    let pwd=document.getElementById("password").value;
    let re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/;
    isValid=re.test(pwd);
    if(!passwordLogoAdded){
        pwdDiv.appendChild(userPasswordLogo);
        passwordLogoAdded = true;
    }
   if(isValid){
        userPasswordLogo.setAttribute('src',"tick.png");
        return true;
   }
   else{
    userPasswordLogo.setAttribute('src',"cross.png");
    return false;
   }
   
}

const checkForm=()=>{
    if(checkPassword() && checkUserId()){
        alert("you can login");
        return true;
    }
    else{
        alert("enter valid details");
        return false;
    }
}



const resetForm=()=>{
   userPasswordLogo.parentNode.removeChild(userPasswordLogo);
   userStatusLogo.parentNode.removeChild(userStatusLogo);
   userLogoAdded=false;
   passwordLogoAdded=false;
}