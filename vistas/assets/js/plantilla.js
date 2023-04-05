const body = document.querySelector("body"),
    modeToggle = body.querySelector(".mode-toggle");
    sidebar = body.querySelector("nav");
    sidebarToggle = body.querySelector(".sidebar-toggle");

/*SUBMENU WRAP*/
let subMenu = document.getElementById("subMenu");
    function toggleMenu(){
    subMenu.classList.toggle("open-submenu");
}

/*Cerrar submenú al hacer clic en cualquier parte de la pantalla*/
window.addEventListener("click", function(event) {
    if (subMenu.classList.contains("open-submenu") && event.target.closest(".profile-details") === null) {
    subMenu.classList.remove("open-submenu");
    }
    });
/*Cerrar submenú al presionar la tecla "Esc"*/
window.addEventListener("keydown", function(event) {
    if (subMenu.classList.contains("open-submenu") && event.key === "Escape") {
    subMenu.classList.remove("open-submenu");
    }
    });
/*Cerrar submenú al hacer clic en el enlace*/
let submenuLinks = document.querySelectorAll(".submenu-link");
    for (let i = 0; i < submenuLinks.length; i++) {
    submenuLinks[i].addEventListener("click", function() {
    subMenu.classList.remove("open-submenu");
    });
    }

/*DarkMode*/
let getMode = localStorage.getItem("mode");
if(getMode && getMode ==="dark"){
    body.classList.toggle("dark");
}

let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close");
}
/*Mantener el cambio de color al recargar página*/
modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark");
    if(body.classList.contains("dark")){
        localStorage.setItem("mode", "dark");
    }else{
        localStorage.setItem("mode", "light");
    }
});
/*Hamburguesa*/
sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close");
    }else{
        localStorage.setItem("status", "open");
    }
})
/*Active Link Dashboard*/
const activePage = window.location.pathname;
const navLateralLinks = document.querySelectorAll('nav a').forEach(link =>{
    if(link.href.includes(`${activePage}`)){
        link.classList.add('activeLi');
        // console.log(`${activePage}`);
    }
})


/*Eye Password*/
function togglePasswordVisibility() {
    const passwordField = this.previousElementSibling;
    const toggleBtnIcon = this.querySelector('i');
    if (passwordField.type === "password") {
    passwordField.type = "text";
    passwordField.dataset.visible = "true";
    toggleBtnIcon.classList.remove('uil-eye-slash');
    toggleBtnIcon.classList.add('uil-eye');
} else {
    passwordField.type = "password";
    passwordField.dataset.visible = "false";
    toggleBtnIcon.classList.add('uil-eye-slash');
    toggleBtnIcon.classList.remove('uil-eye');
    }
}

const passwordFields = document.querySelectorAll('input[type="password"]');
    passwordFields.forEach(function(passwordField) {
    passwordField.addEventListener('input', function() {
        const toggleBtn = this.nextElementSibling;
        if (passwordField.value.trim() !== '') {
            toggleBtn.style.display = 'block';
        } else {
            toggleBtn.style.display = 'none';
        }
    });

    const toggleBtn = passwordField.nextElementSibling;
    toggleBtn.addEventListener('click', togglePasswordVisibility);
});