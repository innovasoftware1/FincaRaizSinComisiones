var index_foto_actual;

function abrirModal(img, index) {
    index_foto_actual = index;
    var modal = document.getElementById("myModal");

    document.getElementById("fotoModal").src = img.src;

    var span = document.getElementsByClassName("close")[0];

    modal.style.display = "block";
   
    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


}

function proxima() {

    var fotosGaleria = document.querySelectorAll('#galeria img');

    if (fotosGaleria.length - 1 == index_foto_actual) {
        index_foto_actual = -1;
    }
    index_foto_actual++;

    document.getElementById("fotoModal").src = fotosGaleria[index_foto_actual].src;

}

function anterior() {

    var fotosGaleria = document.querySelectorAll('#galeria img');

    if (index_foto_actual == 0) {
        index_foto_actual = fotosGaleria.length;
    }
    index_foto_actual--;

    document.getElementById("fotoModal").src = fotosGaleria[index_foto_actual].src;

}

var visibleMenuResponsive = false;
function mostrarMenuResponsive(){
    if (visibleMenuResponsive){
        document.getElementById("nav").className = "";
        visibleMenuResponsive = false;
    }else{
        document.getElementById("nav").className = "responsive";
        visibleMenuResponsive = true;
    }
}
