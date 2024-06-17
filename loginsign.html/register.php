<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bookhavencuentas");
if (!$conexion) {
    echo "No hay conexión: " . mysqli_connect_error();
    exit();
}

// Captura de datos del formulario
$nombre = $_POST["name"];
$correo = $_POST["email"];
$contra = $_POST["password"];

// Verificar si el correo ya está registrado
$consulta_correo = mysqli_query($conexion, "SELECT * FROM cuentas WHERE email = '$correo'");
if (mysqli_num_rows($consulta_correo) > 0) {
    echo "<script>alert('El correo electrónico ya está registrado.');</script>";
    echo "<script>window.location = '/Proyecto_ADRIAN/proyecto/loginsign.html/login.html';</script>";
    exit();
}

// Insertar los datos en la base de datos
$insertar = mysqli_query($conexion, "INSERT INTO cuentas (email, password) VALUES ('$correo', '$contra')");
if ($insertar) {
    echo "<script>alert('Cuenta creada exitosamente.');</script>";
    echo "<script>window.location = '/Proyecto_ADRIAN/proyecto/inicio/inicio.html';</script>";
    exit();
} else {
    echo "<script>alert('Error al crear la cuenta. Por favor, inténtalo de nuevo más tarde.');</script>";
    echo "<script>window.location = '/Proyecto_ADRIAN/proyecto/loginsign.html/login.html';</script>";
    exit();
}
?>
