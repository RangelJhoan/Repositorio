const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e){
    e.preventDefault()

    let data = new FormData(this)
    try {
        var files = $('#archivo')[0].files[0]
        data.append("archivo", files)
    } catch (error) {
        console.log(error)
    }    
    
    let method = this.getAttribute("method")
    let action = this.getAttribute("action")
    let tipo = this.getAttribute("data-form")
    let tipoEnc = this.getAttribute("enctype")
    
    let encabezados = new Headers()

    let config = {
        method: method,
        enctype: tipoEnc,
        contentType: false,
        processData: false,
        headers: encabezados,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    }

    let texto_alerta

    if(tipo === "save"){
        texto_alerta = "Los datos quedarán guardados en el repositorio"
    }else if(tipo === "delete"){
        texto_alerta = "Los datos serán eliminados completamente del repositorio"
    }else if(tipo === "update"){
        texto_alerta = "Los datos del repositorio serán actualizados"
    }else if(tipo === "search"){
        texto_alerta = "Se eliminará el término de búsqueda y tendrá que escribir uno nuevo"
    }else if(tipo === "loans"){
        texto_alerta = "Desea remover los datos seleccionados para préstamos o reservaciones"
    }else{
        texto_alerta = "¿Quiere realizar la operacion solicitada?"
    }

    Swal.fire({
        title: '¿Está seguro?',
        text: texto_alerta,
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(action, config)
            .then(respuesta =>{
                return respuesta.json()
            })
            .catch(e =>{
                console.log("error " + e)
            })
            .then(respuesta => {
                if(respuesta != undefined){
                    return alertas_ajax(respuesta);
                }else{
                    console.log("Error respuesta indefinida")
                }
            })
        }
    })

}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit", enviar_formulario_ajax)
});

function alertas_ajax(alerta){
    if(alerta.Alerta === "simple"){
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        });
    }else if(alerta.Alerta === "recargar"){
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload()
            }
        });
    }else if(alerta.Alerta === "limpiar"){
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".FormularioAjax").reset()
            }
        });
    }else if(alerta.Alerta === "redireccionar"){
        if(alerta.Titulo != undefined){
            Swal.fire({
                title: alerta.Titulo,
                text: alerta.Texto,
                icon: alerta.Tipo,
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = alerta.URL
                }
            });
        }else{
            window.location.href = alerta.URL
        }
    }
}