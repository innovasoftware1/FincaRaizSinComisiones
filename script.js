/* Fotos inciales del slider  */
var index_foto_actual;

function abrirModal(img, index) {
    index_foto_actual = index;
    var modal = document.getElementById("myModal");

    document.getElementById("fotoModal").src = img.src;

    var span = document.getElementsByClassName("close")[0];

    modal.style.display = "block";

    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}
/* Funciones de transicion modal de imagenes - adelante */
function proxima() {

    var fotosGaleria = document.querySelectorAll('#galeria img');

    if (fotosGaleria.length - 1 == index_foto_actual) {
        index_foto_actual = -1;
    }
    index_foto_actual++;

    document.getElementById("fotoModal").src = fotosGaleria[index_foto_actual].src;

}
/* Funciones de transicion modal de imagenes - atras */
function anterior() {

    var fotosGaleria = document.querySelectorAll('#galeria img');

    if (index_foto_actual == 0) {
        index_foto_actual = fotosGaleria.length;
    }
    index_foto_actual--;

    document.getElementById("fotoModal").src = fotosGaleria[index_foto_actual].src;

}

/* ------------------------------------------------------------------------------------------------ */

/* modal contenedor de imagenes subproperties */

let index_foto_actual_subpro = 0;
let imagenesSubGaleriaSubpro = [];

function abrirModalGaleriaSubpro(id_subpropiedad, imagenes) {
    imagenesSubGaleriaSubpro = imagenes;
    index_foto_actual_subpro = 0;

    var modal = document.getElementById("myModalGaleriaSubpro");
    var img = document.getElementById("fotoModalGaleriaSubpro");

    img.src = imagenesSubGaleriaSubpro[index_foto_actual_subpro];

    modal.style.display = "block";

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

function proximaSubpro() {
    if (imagenesSubGaleriaSubpro.length === 0) return;

    index_foto_actual_subpro = (index_foto_actual_subpro + 1) % imagenesSubGaleriaSubpro.length;

    document.getElementById("fotoModalGaleriaSubpro").src = imagenesSubGaleriaSubpro[index_foto_actual_subpro];
}

function anteriorSubpro() {
    if (imagenesSubGaleriaSubpro.length === 0) return;

    index_foto_actual_subpro = (index_foto_actual_subpro - 1 + imagenesSubGaleriaSubpro.length) % imagenesSubGaleriaSubpro.length;

    document.getElementById("fotoModalGaleriaSubpro").src = imagenesSubGaleriaSubpro[index_foto_actual_subpro];
}


/* ------------------------------------------------------------------------------------------------ */

/* Modal de ver detalles de sub-propiedad */
function abrirModalDetalles(titulo, descripcion, area, area_tipo, dimensiones) {
    document.getElementById("titulo").innerText = titulo;
    document.getElementById("descripcion").innerText = descripcion;
    document.getElementById("area").innerText = area;
    document.getElementById("area_tipo").innerText = area_tipo;
    document.getElementById("dimensiones").innerText = dimensiones;

    var modalDetalles = document.getElementById("myModalDetalles");
    modalDetalles.style.display = "block";

    window.onclick = function (event) {
        if (event.target === modalDetalles) {
            modalDetalles.style.display = "none";
        }
    };
}

function cerrarModalDetalles() {
    var modalDetalles = document.getElementById("myModalDetalles");
    modalDetalles.style.display = "none";
}

document.querySelector(".close").onclick = cerrarModalDetalles;

/* ------------------------------------------------------------------------------------------------ */

/* Modal de video de sub-propiedad */
let modalVideo = document.getElementById("myModalVideo");
let videoElement = document.getElementById("videoModal");

function abrirModalVideo(videoUrl) {
    const iframeSrc = `https://www.youtube.com/embed/${extraerIDVideo(videoUrl)}`;
    videoElement.src = iframeSrc;
    modalVideo.style.display = "block";
}

function extraerIDVideo(url) {
    const regExp = /^.*(?:youtu\.be\/|youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/?([^\/\n\s]*)))/;
    const match = url.match(regExp);
    return (match && match[1]) || null;
}

function cerrarModalVideo() {
    modalVideo.style.display = "none";
    videoElement.src = "";
}

modalVideo.addEventListener("click", function (event) {
    if (event.target === modalVideo) {
        cerrarModalVideo();
    }
});

/* ------------------------------------------------------------------------------------------------ */

/* Modal de recorrido 360° */
let modalRecorrido360 = document.getElementById("myModalRecorrido360");
let iframeRecorrido360 = document.getElementById("recorrido360Modal");

function abrirModalRecorrido360(url) {
    iframeRecorrido360.src = url;
    modalRecorrido360.style.display = "block";
}

function cerrarModalRecorrido360() {
    modalRecorrido360.style.display = "none";
    iframeRecorrido360.src = "";
}

modalRecorrido360.addEventListener("click", function (event) {
    if (event.target === modalRecorrido360) {
        cerrarModalRecorrido360();
    }
});

/* ------------------------------------------------------------------------------------------------ */

/* Menu responsivo */
var visibleMenuResponsive = false;
function mostrarMenuResponsive() {
    if (visibleMenuResponsive) {
        document.getElementById("nav").className = "";
        visibleMenuResponsive = false;
    } else {
        document.getElementById("nav").className = "responsive";
        visibleMenuResponsive = true;
    }
}

/* ------------------------------------------------------------------------------------------------ */

/* Funciones de actulizacion de filtros */
function actualizarFiltro() {

    document.querySelectorAll('.filtro').forEach(function (filtro) {
        const selectBtn = filtro.querySelector('.select-btn');
        const selectedItems = filtro.querySelectorAll('.checkbox:checked');


        let selectedText = '';
        selectedItems.forEach(function (item) {
            selectedText += item.nextElementSibling.textContent + ', ';
        });


        if (selectedText) {
            selectedText = selectedText.slice(0, -2);
        } else {
            selectedText = selectBtn.getAttribute('data-value');
        }

        selectBtn.querySelector('.btn-text').textContent = selectedText;
    });
}

document.querySelectorAll('.checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('change', actualizarFiltro);
});

document.querySelectorAll('.select-btn').forEach(function (btn) {
    btn.setAttribute('data-value', btn.querySelector('.btn-text').textContent);
});