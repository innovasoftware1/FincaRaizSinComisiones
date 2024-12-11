var galeria_fotos = {};  // Almacena las fotos de cada subpropiedad

function abrirModalGaleria(id_subpropiedad, fotos) {
    console.log(fotos); // Verifica si las URLs de las fotos están correctas
    if (!galeria_fotos[id_subpropiedad]) {
        galeria_fotos[id_subpropiedad] = {
            fotos: fotos,
            index_foto_actual: 0  // Empezamos con la primera foto
        };
    }

    var modal = document.getElementById("myModalGaleria");
    var imgElement = document.getElementById("fotoModalGaleria");

    // Asigna la URL de la primera imagen de la galería
    imgElement.src = galeria_fotos[id_subpropiedad].fotos[galeria_fotos[id_subpropiedad].index_foto_actual];

    // Verifica si la imagen está siendo cargada correctamente
    imgElement.onload = function() {
        console.log('Imagen cargada correctamente');
    };
    imgElement.onerror = function() {
        console.log('Error al cargar la imagen');
    };

    modal.style.display = "block";  // Muestra el modal

    // Cerrar el modal
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
        modal.style.display = "none";
    }

    // Cerrar el modal si se hace clic fuera de él
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}
