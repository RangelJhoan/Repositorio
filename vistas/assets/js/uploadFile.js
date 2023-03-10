let fileInput = document.getElementById("file-input");
let fileList = document.getElementById("files-list");
let numOfFiles = document.getElementById("num-of-files");
let progressBar = document.getElementById("progress-bar");

let xhr = new XMLHttpRequest();

function clearFileList() {
    fileList.innerHTML = "";
    progressBar.style.width = `0%`;
    progressBar.innerHTML = `0%`;
}

xhr.upload.addEventListener("loadstart", function() {
    progressBar.style.width = `0%`;
    progressBar.innerHTML = `0%`;
}, false);

xhr.upload.addEventListener("progress", function(event) {
    if (event.lengthComputable) {
        let percentComplete = Math.round((event.loaded / event.total) * 100);
        progressBar.style.width = `${percentComplete}%`;
        progressBar.innerHTML = `${percentComplete}%`;
    }
}, false);

fileInput.addEventListener("change", () => {
    if (fileInput.files.length === 0) {
        clearFileList();
        return;
    }

    fileList.innerHTML = "";
    for (i of fileInput.files) {
        let listItem = document.createElement("li");
        let fileName = i.name;
        let fileSize = (i.size / 1024).toFixed(1);
        listItem.innerHTML = `<a href="#" onclick="window.open('${URL.createObjectURL(i)}')" class="link-estilo"> ${fileName} </a><p class="tamano-archivo">${fileSize}KB</p>`;
        if (fileSize >= 1024) {
            fileSize = (fileSize / 1024).toFixed(1);
            listItem.innerHTML = `<a href="#" onclick="window.open('${URL.createObjectURL(i)}')" class="link-estilo"> ${fileName} </a><p class="tamano-archivo">${fileSize}MB</p>`;
        }
        fileList.appendChild(listItem);

        xhr.open("POST", "");
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(i);
    }
});

fileInput.addEventListener("input", () => {
    if (fileInput.value === '') {
        progressBar.style.width = `0%`;
        progressBar.innerHTML = '';
    }
});




// CAMPO DEL AÑO DEL RECURSO
let maximo = new Date().getFullYear(); // Obtener el año actual
document.querySelector('input[name="anioRecurso"]').setAttribute('max', maximo);