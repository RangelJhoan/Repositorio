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
                labels: ['Puntos positivos', 'Puntos negativos'],
                datasets: [{
                    label: 'Calificaciones ',
                    data: data,
                    borderWidth: 1,
                    backgroundColor: [
                        '#65ca65', // Para "Puntos positivos"
                        'rgb(241, 95, 95)' // Para "Puntos Negativos"
                    ]
                }]
                },
                options: {
                    plugins:{
                        title:{
                            display:true,
                            text: 'Feedbacks generales de mis recursos',
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

/** SCRIPT PARA LAS CARDS DEL DASHBOARD*/
document.getElementById("cards").onmousemove = e => {
    for(const card of document.getElementsByClassName("card")) {
        const rect = card.getBoundingClientRect(),
            x = e.clientX - rect.left,
            y = e.clientY - rect.top;
        card.style.setProperty("--mouse-x", `${x}px`);
        card.style.setProperty("--mouse-y", `${y}px`);
    };
}