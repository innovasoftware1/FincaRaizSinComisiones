function archivo(evt) {
    var noutputs = 0;

    // Limpiamos el contenedor antes de agregar nuevas imágenes
    $('.contenedor-foto-publicacion').remove();

    var files = evt.target.files;

    // Iteramos sobre cada archivo seleccionado
    for (var i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();

        reader.onload = (function(theFile) {
            return function(e) {
                noutputs++;
                // Creamos un contenedor para cada foto y la añadimos al contenedor principal
                var output = $('<output class="contenedor-foto-galeria" id="foto-' + noutputs + '"></output>');
                var img = $('<img class="foto-galeria" src="' + e.target.result + '" title="' + escape(theFile.name) + '"/>');
                var eliminarBtn = $('<button type="button" class="eliminar-foto">X</button>');

                // Agregamos la imagen y el botón de eliminar al contenedor
                output.append(img).append(eliminarBtn);
                $('#contenedor-fotos-publicacion').append(output);

                // Añadimos el manejador de eventos para eliminar la foto
                eliminarBtn.on('click', function() {
                    // Eliminamos el contenedor de la foto
                    output.remove();
                    // Si lo deseas, también puedes quitar la foto del input (para no enviarla)
                    // eliminarFotoDelFormulario(f.name); // Si quieres eliminar la foto del input
                });
            };
        })(f);

        reader.readAsDataURL(f);
    }
}

document.getElementById('fotos').addEventListener('change', archivo, false);
