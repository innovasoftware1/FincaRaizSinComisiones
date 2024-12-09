function archivo(evt) {
    var noutputs = 0;


    $('.contenedor-foto-publicacion').remove();
    var files = evt.target.files; 

    for (var i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();

        reader.onload = (function(theFile) {
            return function(e) {
                noutputs++;
                $('#contenedor-fotos-publicacion').append('<output class = "contenedor-foto-galeria" id=' + noutputs + '></output>');
                document.getElementById(noutputs).innerHTML = ['<img class="foto-galeria" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');

            };
        })(f);

        reader.readAsDataURL(f);
    }

}

document.getElementById('fotos').addEventListener('change', archivo, false);