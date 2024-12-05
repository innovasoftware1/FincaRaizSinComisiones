function eliminarFoto(idFoto, idContenedor) {

    fotosAEliminar = idFoto + "," + fotosAEliminar;
    document.getElementById('fotosAEliminar').value = fotosAEliminar;


    $('#' + idContenedor).remove();
}

var idEliminar;

function abrirModal(id) {
    idEliminar = id;
    var modal = document.getElementById("myModal");

    var btn = document.getElementById(id);

    var span = document.getElementsByClassName("close")[0];

    modal.style.display = "flex";
   
    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function eliminarPropiedad() {
    window.location.href = "eliminar-propiedad.php?idPropiedad=" + idEliminar;
}

function tipoDeMuestra(formato) {
    if (formato == "f") {
        document.getElementById("personalizada").style.display = "none";
    } else {
        document.getElementById("personalizada").style.display = "block";
    }
}

function eliminarUsuario() {
    $.ajax({
        url: 'eliminar-usuario.php',  
        type: 'GET',
        data: { id: idEliminar },
        success: function (response) {
            alert("El usuario ha sido eliminado.");
            window.location.reload(); 
        },
        error: function (xhr, status, error) {
            alert("Hubo un error al eliminar el usuario.");
        }
    });
}
