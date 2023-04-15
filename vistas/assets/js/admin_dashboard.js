/** SCRIPT para consultar los datos de la gráfica */
$(document).ready(function() {
    // Valor a enviar
    var valorPOST = 'graficar_admin_cantidad_tipo_usuarios';

    $.ajax({
        url: '../ajax/usuarioAjax.php',
        type: 'POST',
        data: { graficar_admin_usuarios: valorPOST },
        dataType: 'json',
        success: function(data) {
            /*Script para gráficas*/
            const ctx = document.getElementById('myChart');
            new Chart(ctx, {
                type: 'polarArea',
                data: {
                labels: ['Estudiantes', 'Docentes', 'Administradores'],
                datasets: [{
                    label: 'Número de usuarios',
                    data: data,
                    borderWidth: 1
                }]
                },
                options: {
                    plugins:{
                        title:{
                            display:true,
                            text: 'Cantidad específica de usuarios',
                            font:{
                                size:18,
                                weight:'bold'
                                }
                            }
                        }
                    }
                });
        }
    });
});
