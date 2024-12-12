/* function mostrarRecorrido() {
    const imagenPrincipal = document.getElementById('imagen-principal');
    const videoContainer = document.getElementById('video-container');
    const recorridoContainer = document.getElementById('recorrido-container');
    
    imagenPrincipal.style.display = 'none'; 
    videoContainer.style.display = 'none';
    recorridoContainer.style.display = 'block';
}

function mostrarVideo() {
    const imagenPrincipal = document.getElementById('imagen-principal');
    const videoContainer = document.getElementById('video-container');
    const recorridoContainer = document.getElementById('recorrido-container');
    
    imagenPrincipal.style.display = 'none'; 
    recorridoContainer.style.display = 'none';
    videoContainer.style.display = 'block';
}

function mostrarFotos() {
    const imagenPrincipal = document.getElementById('imagen-principal');
    const videoContainer = document.getElementById('video-container');
    const recorridoContainer = document.getElementById('recorrido-container');

    videoContainer.style.display = 'none';
    recorridoContainer.style.display = 'none';
    imagenPrincipal.style.display = 'block'; 
}

 */

/* ----------------------------------------------------------------------------------------- */
/* ------------------------- OCULTAR SLIDER GALERIA DE FOTOS ------------------------------- */
/* ----------------------------------------------------------------------------------------- */
function mostrarRecorrido() {
    const imagenPrincipal = document.getElementById('imagen-principal');
    const videoContainer = document.getElementById('video-container');
    const recorridoContainer = document.getElementById('recorrido-container');
    const galeria = document.getElementById('galeria');
    const hr = document.querySelector('hr');

    imagenPrincipal.style.display = 'none'; 
    videoContainer.style.display = 'none';
    recorridoContainer.style.display = 'block';
    galeria.style.display = 'none'; 
    hr.style.display = 'none'; 
}

function mostrarVideo() {
    const imagenPrincipal = document.getElementById('imagen-principal');
    const videoContainer = document.getElementById('video-container');
    const recorridoContainer = document.getElementById('recorrido-container');
    const galeria = document.getElementById('galeria');
    const hr = document.querySelector('hr');

    imagenPrincipal.style.display = 'none'; 
    recorridoContainer.style.display = 'none';
    videoContainer.style.display = 'block';
    galeria.style.display = 'none'; // Oculta la galería
    hr.style.display = 'none'; // Oculta el <hr>
}

function mostrarFotos() {
    const imagenPrincipal = document.getElementById('imagen-principal');
    const videoContainer = document.getElementById('video-container');
    const recorridoContainer = document.getElementById('recorrido-container');
    const galeria = document.getElementById('galeria');
    const hr = document.querySelector('hr');

    videoContainer.style.display = 'none';
    recorridoContainer.style.display = 'none';
    imagenPrincipal.style.display = 'block'; 
    galeria.style.display = 'block'; 
    hr.style.display = 'block'; 
}
