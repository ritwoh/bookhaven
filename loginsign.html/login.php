<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bookhavencuentas");
if (!$conexion) {
    echo "No hay conexión: " . mysqli_connect_error();
    exit();
}

// Captura de datos del formulario
$correo = $_POST["email"];
$contra = $_POST["password"];

// Verificar credenciales
$consulta = mysqli_query($conexion, "SELECT * FROM cuentas WHERE email = '$correo' AND password = '$contra'");
if (mysqli_num_rows($consulta) > 0) {
    echo "<script>alert('Inicio de sesión exitoso.');</script>";
    echo "<script>window.location = '/Proyecto_ADRIAN/proyecto/inicio/inicio.html';</script>";
} else {
    echo "<script>alert('Correo o contraseña incorrectos.');</script>";
    echo "<script>window.location = '/Proyecto_ADRIAN/proyecto/loginsign.html/login.html';</script>";
}
?>
