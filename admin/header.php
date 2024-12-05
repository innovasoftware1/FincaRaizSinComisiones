<header>
    <h1>Administración de Finca Riz</h1>
    <h2>Sistema Administrativo</h2>

    <button id="userBtn" class="user-btn">
        <img src="../../img/admin.svg" alt="Icono de usuario" class="user-icon">
    </button>
</header>

<div id="userModal" class="modal">
    <div class="modal-content">
        <div class="user-info">
            <img src="user-image.jpg" alt="User" class="user-avatar">
            <div class="user-details">
                <h4 id="userName">Feldman Rodriguez</h4>
                <p id="userEmail">admin@correo.com</p>
            </div>
        </div>
        <hr class="hr-modal">
        <div class="modal-options">
            <button class="config" id="configBtn" onclick="redirectToConfig()">
                <span class="icon-c">&#9881;</span> Config.
            </button>
            <button class="cerrar" id="cerrarSesionLink">
                <span class="icon-l"><i class="fas fa-sign-out-alt"></i></span> Logout
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function redirectToConfig() {
        window.location.href = 'configuracion.php';
    }
</script>

<script>
    const userBtn = document.getElementById("userBtn");
    const modal = document.getElementById("userModal");

    function openModal() {
        modal.style.display = "flex";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    userBtn.addEventListener("click", function() {
        if (modal.style.display === "flex") {
            closeModal();
        } else {
            openModal();
        }
    });

    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.getElementById('cerrarSesionLink').addEventListener('click', function(event) {
        event.preventDefault();

        Swal.fire({
            title: '¿Estás seguro de cerrar sesión?',
            text: '¡Se cerrará tu sesión y serás redirigido al login!',
            icon: 'warning',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, cerrar sesión'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Sesión terminada',
                    text: 'Tu sesión se ha cerrado exitosamente.',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'cerrar-sesion.php';
                });
            }
        });
    });
</script>