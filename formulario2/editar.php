<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Verifica si se ha pasado el folio en la URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['folio'])) {
    // Obtiene el folio del registro a editar desde la URL
    $folio = $_GET['folio'];

    // Realiza una consulta SQL para obtener los datos del registro con el folio proporcionado
    $consulta = "SELECT * FROM datos WHERE folio = '$folio'";
    $resultado = mysqli_query($conex, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        // El registro existe, obtén los datos del registro
        $fila = mysqli_fetch_assoc($resultado);

        // Crea un formulario de edición con los datos del registro
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Registro</title>
            <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            padding: 10px;
        }

        form {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            margin: 0 auto;
            max-width: 600px;
            text-align: left;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
        }

        input, textarea {
            width: 45%; /* Establece el ancho de cada campo */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        input[type="submit"] {
            background: linear-gradient(90deg, #2ecc71 0%, #27ae60 50%);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: transform 0.2s; /* Transición suave del efecto de zoom */
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: scale(1.1); /* Zoom al pasar el mouse */
        }
    </style>
        </head>
        <body>
    <h1>EDITAR REGISTRO</h1>
    <form method="post" action="guardar_edicion.php">
        <div class="form-row">
            <label for="fecha">FECHA:</label>
            <input type="text" name="fecha" value="<?php echo $fila['fecha']; ?>">
        </div>

        <div class="form-row">
            <label for="cliente">CLIENTE:</label>
            <input type="text" name="cliente" value="<?php echo $fila['cliente']; ?>">
        </div>

        <div class="form-row">
            <label for="lote">LOTE:</label>
            <input type="text" name="lote" value="<?php echo $fila['lote']; ?>">
        </div>

        <div class="form-row">
            <label for="folio">FOLIO:</label>
            <input type="text" name="folio" value="<?php echo $fila['folio']; ?>">
        </div>

        <div class="form-row">
            <label for="hora">HORA:</label>
            <input type="time" name="hora" value="<?php echo $fila['hora']; ?>">
        </div>

        <div class="form-row">
            <label for="peso1">PESO 1:</label>
            <input type="text" name="peso1" value="<?php echo $fila['peso1']; ?>">
        </div>

        <div class="form-row">
            <label for="peso2">PESO 2:</label>
            <input type="text" name="peso2" value="<?php echo $fila['peso2']; ?>">
        </div>

        <div class="form-row">
            <label for="peso3">PESO 3:</label>
            <input type="text" name="peso3" value="<?php echo $fila['peso3']; ?>">
        </div>

        <div class="form-row">
            <label for="peso4">PESO 4:</label>
            <input type="text" name="peso4" value="<?php echo $fila['peso4']; ?>">
        </div>

        <div class="form-row">
            <label for="peso5">PESO 5:</label>
            <input type="text" name="peso5" value="<?php echo $fila['peso5']; ?>">
        </div>

        <div class="form-row">
            <label for="peso6">PESO 6:</label>
            <input type="text" name="peso6" value="<?php echo $fila['peso6']; ?>">
        </div>

        <div class="form-row">
            <label for="peso7">PESO 7:</label>
            <input type="text" name="peso7" value="<?php echo $fila['peso7']; ?>">
        </div>

        <div class="form-row">
            <label for="peso8">PESO 8:</label>
            <input type="text" name="peso8" value="<?php echo $fila['peso8']; ?>">
        </div>

        <div class="form-row">
            <label for="peso9">PESO 9:</label>
            <input type="text" name="peso9" value="<?php echo $fila['peso9']; ?>">
        </div>

        <div class="form-row">
            <label for="peso10">PESO 10:</label>
            <input type="text" name="peso10" value="<?php echo $fila['peso10']; ?>">
        </div>

        <div class="form-row">
            <label for="observaciones">OBSERVACIONES:</label>
            <textarea name="observaciones"><?php echo $fila['observaciones']; ?></textarea>
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</body>
        </html>
        <?php
    } else {
        // El registro no existe, muestra un mensaje de error o redirige a una página de error
        echo "El registro no existe.";
    }
} else {
    // No se ha proporcionado un folio válido, muestra un mensaje de error o redirige a una página de error
    echo "Folio no válido.";
}
?>