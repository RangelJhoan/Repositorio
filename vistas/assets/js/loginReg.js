const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});


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
