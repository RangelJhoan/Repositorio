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
                type: 'bar',
                data: {
                    labels: ['Estudiantes', 'Docentes', 'Administradores'],
                    datasets: [{
                        label: 'Estudiantes',
                        data: [Math.abs(Math.round(data[0])), 0, 0],
                        backgroundColor: '#008640',
                        borderColor: '#008640',
                        borderWidth: 1
                    },
                    {
                        label: 'Docentes',
                        data: [0, Math.abs(Math.round(data[1])), 0],
                        backgroundColor: '#506591',
                        borderColor: '#506591',
                        borderWidth: 1
                    },
                    {
                        label: 'Administradores',
                        data: [0, 0, Math.abs(Math.round(data[2]))],
                        backgroundColor: '#DBA034',
                        borderColor: '#DBA034',
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
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value, index, values) {
                                    return value % 2 === 0 ? value : '';
                                }
                            }
                        }
                    },
                    barPercentage: 1.5, // ajusta el ancho de las barras
                    barThickness: 'flex' // establece el grosor de las barras
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