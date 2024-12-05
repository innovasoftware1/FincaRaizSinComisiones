function mostrarRecorrido() {
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
