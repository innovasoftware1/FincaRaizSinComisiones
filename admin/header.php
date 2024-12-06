<?php
// Inicia un buffer de salida para evitar problemas con encabezados
ob_start();

// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica la autenticación del usuario
if (!isset($_SESSION['usuarioLogeado']) || !isset($_SESSION['rol_id'])) {
    header("Location: ../login.php");
    exit();
}

// Define la constante BASE_URL si no está definida
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/FincaRaizV1/fincaRaizInnova/');
}
?>

<!-- Tu HTML comienza aquí -->
<header>
    <h1>Administración de Finca Raiz</h1>
    <h2>Sistema Administrativo</h2>



    <button id="userBtn" class="user-btn">
    <img src="<?php echo BASE_URL; ?>img/admin.svg" alt="Icono de usuario" class="user-icon">
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
    // Constante BASE_URL definida desde PHP
    const BASE_URL = "<?php 
        if (!defined('BASE_URL')) {
            define('BASE_URL', 'http://localhost/FincaRaizV1/fincaRaizInnova/');
        }
        echo BASE_URL; 
    ?>";

    function redirectToConfig() {
        window.location.href = BASE_URL + 'configuracion.php';
    }

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
                    window.location.href = BASE_URL + 'admin/cerrar-sesion.php';
                });
            }
        });
    });
</script>
