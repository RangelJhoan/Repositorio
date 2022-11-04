const modalEditarUsuario = document.getElementById('modal-container-edit-user');
const botonEditarUsuario = document.getElementById('btn-abrir-editar-usuario');
const botonCerrarEditarUsuario = document.getElementById('btn-cerrar-editar-usuario');

botonEditarUsuario.addEventListener('click', () => {
    modalEditarUsuario.classList.add('mostrar-modal-editarusuario-js');
});

botonCerrarEditarUsuario.addEventListener('click', () => {
    modalEditarUsuario.classList.remove('mostrar-modal-editarusuario-js');
});