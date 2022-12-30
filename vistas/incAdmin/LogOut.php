<script>
    let btn_salir = document.querySelector("#cerrar_sesion")

    btn_salir.addEventListener('click', function(e){
        e.preventDefault()
        Swal.fire({
            title: '¿Está seguro de cerrar la sesión?',
            text: "Está a punto de cerrar sesión",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: "#d33",
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){
                let url = '<?php echo SERVER_URL ?>ajax/usuarioAjax.php'
                let id_persona = '<?php echo $uc->encryption($_SESSION['id_persona'])?>'
                let correo_usuario = '<?php echo $uc->encryption($_SESSION['correo_usuario'])?>'

                let datos = new FormData()

                datos.append("id_persona", id_persona)
                datos.append("correo_usuario", correo_usuario)

                fetch(url, {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta =>{
                    return respuesta.json()
                })
                .catch(e =>{
                    console.log("error " + e)
                })
                .then(respuesta => {
                    if(respuesta != undefined){
                        return alertas_ajax(respuesta)
                    }else{
                        console.log("Error respuesta indefinida")
                    }
                })
            
            }
        })
    })
</script>