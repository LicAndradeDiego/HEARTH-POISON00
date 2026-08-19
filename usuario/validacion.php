<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Verifica que haya iniciado sesión
if (!isset($_SESSION['Rol'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Acceso Denegado',
                text: 'Debe iniciar sesión primero.',
                confirmButtonColor: '#ffffff',
                confirmButtonText: '<span style=\"color:#000;\">Entendido</span>',
                background: '#0f0f0f',
                color: '#fff'
            }).then(() => {
                window.location.href = 'login.php';
            });
        });
    </script>
    ";
    exit();
}

// 2. Verifica que sea administrador (comparando en minúsculas por seguridad)
if (strtolower($_SESSION['Rol']) != "administrador") {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Sin Permisos',
                text: 'Solo el administrador puede realizar esta acción.',
                confirmButtonColor: '#ffffff',
                confirmButtonText: '<span style=\"color:#000;\">Entendido</span>',
                background: '#0f0f0f',
                color: '#fff'
            }).then(() => {
                window.location.href = 'leerusuario.php';
            });
        });
    </script>
    ";
    exit();
}

if (!isset($_GET['CI'])) {
    header("Location: leerusuario.php");
    exit();
}

$CI = $_GET['CI'];
?>