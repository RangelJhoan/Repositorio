let close = document.querySelectorAll(".close")[0];
let open = document.querySelectorAll(".password-forget-text")[0];
let modal = document.querySelectorAll(".modal-pswd")[0];
let modalCont = document.querySelectorAll(".modal-container")[0];

open.addEventListener("click", function(e){
    e.preventDefault();
    modalCont.style.opacity ="1";
    modalCont.style.visibility ="visible";
    modal.classList.toggle("modal-close-pswd");
});

close.addEventListener("click", function(e){
    modal.classList.toggle("modal-close-pswd");
    setTimeout(function(){ 
        modalCont.style.opacity ="0";
        modalCont.style.visibility ="hidden";  
    },300)
});
window.addEventListener("click",function(e){
    if(e.target == modalCont){
        modal.classList.toggle("modal-close-pswd");
        setTimeout(function(){ 
            modalCont.style.opacity ="0";
            modalCont.style.visibility ="hidden";  
        },300)
    }
})