<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos enviados desde el formulario de edición
    $fecha = $_POST['fecha'];
    $cliente = $_POST['cliente'];
    $lote = $_POST['lote'];
    $folio = $_POST['folio'];
    $hora = $_POST['hora'];
    $peso1 = $_POST['peso1'];
    $peso2 = $_POST['peso2'];
    $peso3 = $_POST['peso3'];
    $peso4 = $_POST['peso4'];
    $peso5 = $_POST['peso5'];
    $peso6 = $_POST['peso6'];
    $peso7 = $_POST['peso7'];
    $peso8 = $_POST['peso8'];
    $peso9 = $_POST['peso9'];
    $peso10 = $_POST['peso10'];
    $observaciones = $_POST['observaciones'];

    // Puedes obtener otros datos editados de manera similar

    // Valida los datos si es necesario (ejemplo: verificar que no estén vacíos)

    // Realiza una consulta SQL para actualizar el registro en la base de datos
    $consulta = "UPDATE datos SET fecha = '$fecha', cliente = '$cliente', lote = '$lote', hora = '$hora', peso1 = '$peso1', peso2 = '$peso2', peso3 = '$peso3', peso4 = '$peso4', peso5 = '$peso5', peso6 = '$peso6', peso7 = '$peso7', peso8 = '$peso8', peso9 = '$peso9', peso10 = '$peso10', observaciones = '$observaciones' WHERE folio = '$folio'";

    if (mysqli_query($conex, $consulta)) {
        // La actualización se realizó con éxito, redirige a la página principal o muestra un mensaje de éxito
        header("Location: index.php"); // Cambia "index.php" por la URL de tu página principal.
        exit();
    } else {
        // La actualización falló, muestra un mensaje de error o maneja el error de otra manera
        echo "Error al actualizar los datos: " . mysqli_error($conex);
    }
}

// Cierra la conexión a la base de datos si es necesario
mysqli_close($conex);
?>