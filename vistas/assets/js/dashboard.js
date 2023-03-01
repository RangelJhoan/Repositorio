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

/*Script para gráficas*/

//<?php
// $sql = "SELECT COUNT(*) AS count FROM usuario WHERE id_tipo_usuario=1";
// $result = $conn->query($sql);
// $admin_count = $result->fetch_assoc()["count"];

// $sql = "SELECT COUNT(*) AS count FROM usuario WHERE id_tipo_usuario=2";
// $result = $conn->query($sql);
// $docente_count = $result->fetch_assoc()["count"];

// $sql = "SELECT COUNT(*) AS count FROM usuario WHERE id_tipo_usuario=3";
// $result = $conn->query($sql);
// $estudiante_count = $result->fetch_assoc()["count"];

// $data = array(
//     $admin_count,
//     $docente_count,
//     $estudiante_count
// );
//?>
const ctx = document.getElementById('myChart');
const earn = document.getElementById('earnings');
new Chart(ctx, {
    type: 'polarArea',
    data: {
    labels: ['Administradores', 'Docentes', 'Estudiantes'],
    datasets: [{
        label: 'Número de usuarios',
        data: [1, 2, 3],
        // data: <?//php echo json_encode($data); ?>

        borderWidth: 1
    }]
    },
    options: {
        scales: {
            y: {
            beginAtZero: true,
            responsive:false
            }
        },
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

new Chart(earn, {
    type: 'bar',
    data: {
    labels: ['Administradores', 'Docentes', 'Estudiantes'],
    datasets: [{
        label: 'Archivos de recursos:',
        data: [1, 2, 3],
        borderWidth: 1
    }]
    },
    options: {
    scales: {
        y: {
        beginAtZero: true,
        responsive:false
    }
        },
        plugins:{
            title:{
                display:true,
                text: 'Cantidad específica de los tipos de archivos',
                font:{
                    size:18,
                    weight:'bold'
                    }
                }
            }
        }
    });