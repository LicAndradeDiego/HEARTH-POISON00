<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['Nombre'] ?? '';
$CI = $_POST['CI'] ?? '';

$sql = "SELECT * FROM usuario WHERE nombre='$nombre' AND CI='$CI'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    $fila = $result->fetch_assoc();

    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];

    $rol = strtolower(trim($fila['rol']));

    if ($rol == 'administrador') {
        header("Location: ../administrador.php");
        exit();
    } 
    elseif ($rol == 'vendedor') {
        header("Location: ../vendedor.php");
        exit();
    } 
    else {
        echo "<script>
                alert('Rol no reconocido.');
                window.location.href='crearusuario.php';
              </script>";
    }

} else {
    echo "<script>
            alert('Nombre o CI incorrectos');
            window.location.href='paginasesion.php';
          </script>";
}

$conn->close();
?>