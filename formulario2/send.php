<?php
include("conexion.php");
date_default_timezone_set('America/Santiago');

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    // Se ha enviado el formulario, procesa los datos
    $date = trim($_POST['date']);
    $newCustomer = trim($_POST['newCustomer']);
    $lote = trim($_POST['lote']);

    // Agregar el nuevo cliente a la tabla de clientes
    $consultaNuevoCliente = "INSERT INTO clientes (nombre_cliente) VALUES ('$newCustomer')";
    $resultadoNuevoCliente = mysqli_query($conex, $consultaNuevoCliente);
    if ($resultadoNuevoCliente) {
        // Éxito al agregar el nuevo cliente
        // Puedes agregar aquí más lógica si necesitas realizar alguna acción adicional
    } else {
        // Manejo de error al agregar el cliente
    }

// Obtén el último número de folio para la fecha actual
$consultaUltimoFolio = "SELECT MAX(SUBSTRING(folio, 10)) AS ultimoNumero FROM datos WHERE fecha = '$date'";
$resultadoUltimoFolio = mysqli_query($conex, $consultaUltimoFolio);
$filaUltimoFolio = mysqli_fetch_assoc($resultadoUltimoFolio);
$ultimoNumero = $filaUltimoFolio['ultimoNumero'];

// Si no hay folios para la fecha actual, comienza desde 1
$nuevoNumero = ($ultimoNumero != null) ? intval($ultimoNumero) + 1 : 1;

// Formatea el número para que siempre tenga dos dígitos
$numeroFormateado = str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT);

// Construye el nuevo folio con el nuevo número y la fecha
$invoice = "" . date("Ymd", strtotime($date)) . $numeroFormateado;

// Verifica si el folio ya existe para la fecha actual
$consultaFolioExistente = "SELECT COUNT(*) AS folioExistente FROM datos WHERE folio = '$invoice'";
$resultadoFolioExistente = mysqli_query($conex, $consultaFolioExistente);
$filaFolioExistente = mysqli_fetch_assoc($resultadoFolioExistente);
$folioExistente = $filaFolioExistente['folioExistente'];

// Si el folio ya existe, incrementa el número y vuelve a verificar
while ($folioExistente > 0) {
    $nuevoNumero++;
    $numeroFormateado = str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT);
    $invoice = "" . date("Ymd", strtotime($date)) . $numeroFormateado;

    $consultaFolioExistente = "SELECT COUNT(*) AS folioExistente FROM datos WHERE folio = '$invoice'";
    $resultadoFolioExistente = mysqli_query($conex, $consultaFolioExistente);
    $filaFolioExistente = mysqli_fetch_assoc($resultadoFolioExistente);
    $folioExistente = $filaFolioExistente['folioExistente'];
}

// Ahora, $invoice contiene un folio único para la fecha actual

    $hora = date("H:i:s");
    $peso1 = strval($_POST['peso1']);  // Convierte a cadena
    $peso2 = strval($_POST['peso2']);  // Convierte a cadena
    $peso3 = strval($_POST['peso3']);  // Convierte a cadena
    $peso4 = strval($_POST['peso4']);  // Convierte a cadena
    $peso5 = strval($_POST['peso5']);  // Convierte a cadena
    $peso6 = strval($_POST['peso6']);  // Convierte a cadena
    $peso7 = strval($_POST['peso7']);  // Convierte a cadena
    $peso8 = strval($_POST['peso8']);  // Convierte a cadena
    $peso9 = strval($_POST['peso9']);  // Convierte a cadena
    $peso10 = strval($_POST['peso10']);  // Convierte a cadena
    $observaciones = trim($_POST['observaciones']);

    // Realiza una consulta SQL para verificar si el folio ya existe en la base de datos.
$consulta = "SELECT * FROM datos WHERE folio = '$invoice'";
$resultado = mysqli_query($conex, $consulta);

if (mysqli_num_rows($resultado) > 0) {
    // El folio ya existe en la base de datos, muestra un mensaje de error.
    echo "<h3 class='error'>Error: El folio ya existe en la base de datos.</h3>";
} else {
    // El folio no existe, ejecuta la consulta INSERT en la base de datos.
    $consulta = "INSERT INTO datos(fecha, cliente, lote, folio, hora, peso1, peso2, peso3, peso4, peso5, peso6, peso7, peso8, peso9, peso10, observaciones)
         VALUES ('$date', '$newCustomer', '$lote', '$invoice', '$hora', 
         '$peso1', '$peso2', '$peso3', '$peso4', '$peso5', '$peso6', '$peso7', '$peso8', '$peso9', '$peso10', '$observaciones')";
    $resultado = mysqli_query($conex, $consulta);
    if ($resultado) {
        echo "<h3 class='success'>TU REGISTRO SE HA COMPLETADO</h3>";
    }
}
}

// Realiza una consulta SQL para obtener los registros y guárdalos en una variable de sesión.
if (!isset($_SESSION['resultados'])) {
    $consulta = "SELECT * FROM datos ORDER BY folio";
    $resultado = mysqli_query($conex, $consulta);

    $_SESSION['resultados'] = array();

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $_SESSION['resultados'][] = $fila;
    }
}
// Obtener los resultados de la variable de sesión y mostrarlos en la tabla.
if (isset($_SESSION['resultados'])) {
    foreach ($_SESSION['resultados'] as $fila) {
        echo "<tr>";
        echo "<tr class='data-row' data-folio='{$fila['folio']}'>";
        echo "<td>{$fila['fecha']}</td>";
        echo "<td>{$fila['cliente']}</td>";
        echo "<td>{$fila['lote']}</td>";
        echo "<td>{$fila['folio']}</td>";
        echo "<td>{$fila['hora']}</td>";
        echo "<td>{$fila['peso1']}</td>";
        echo "<td>{$fila['peso2']}</td>";
        echo "<td>{$fila['peso3']}</td>";
        echo "<td>{$fila['peso4']}</td>";
        echo "<td>{$fila['peso5']}</td>";
        echo "<td>{$fila['peso6']}</td>";
        echo "<td>{$fila['peso7']}</td>";
        echo "<td>{$fila['peso8']}</td>";
        echo "<td>{$fila['peso9']}</td>";
        echo "<td>{$fila['peso10']}</td>";
        echo "<td>{$fila['observaciones']}</td>";
        echo "<td>";
        echo "<button class='edit-button' data-folio='{$fila['folio']}'>Editar</button>";
        echo "<button class='delete-button' data-folio='{$fila['folio']}'>Eliminar</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
mysqli_close($conex);
?>