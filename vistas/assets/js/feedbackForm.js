let close = document.querySelectorAll(".close")[0];
let open = document.querySelectorAll(".buttonFeedbackOpen")[0];
let modal = document.querySelectorAll(".modal-feedback")[0];
let modalCont = document.querySelectorAll(".modal-container")[0];
let html = document.querySelector('html');

open.addEventListener("click", function(e){
    e.preventDefault();
    modalCont.style.opacity ="1";
    modalCont.style.visibility ="visible";
    modal.classList.toggle("modal-close-feedback");
    html.style.overflow = 'hidden';
});

close.addEventListener("click", function(e){
    modal.classList.toggle("modal-close-feedback");
    setTimeout(function(){ 
        modalCont.style.opacity ="0";
        modalCont.style.visibility ="hidden";  
    },300);
    html.style.overflow = 'auto';
});

window.addEventListener("click",function(e){
    if(e.target == modalCont){
        modal.classList.toggle("modal-close-feedback");
        setTimeout(function(){ 
            modalCont.style.opacity ="0";
            modalCont.style.visibility ="hidden";  
        },300);
        html.style.overflow = 'auto';
    }
});