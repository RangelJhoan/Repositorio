/** SCRIPT para consultar los datos de la gráfica */

$(document).ready(function() {
    // Valor a enviar
    var valorPOST = 'graficar_docente_calificaciones_totales';

    $.ajax({
        url: '../ajax/recursoAjax.php',
        type: 'POST',
        data: { graficar_docente_calificaciones_totales: valorPOST },
        dataType: 'json',
        success: function(data) {
            /*Script para gráficas*/
            const ctx = document.getElementById('myChart');
            new Chart(ctx, {
                type: 'pie',
                data: {
                labels: ['Puntos Positivos', 'Puntos Negativos'],
                datasets: [{
                    label: 'Número de calificaciones',
                    data: data,
                    borderWidth: 1
                }]
                },
                options: {
                    plugins:{
                        title:{
                            display:true,
                            text: 'Calificación de mis recursos',
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
