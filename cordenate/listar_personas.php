<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

// Desactiva la salida de errores en el navegador (se recomienda en producción)
error_reporting(0);

// Conexión a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'cordenate');

// Verificar la conexión
if ($mysqli->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos"]);
    exit();
}

// Verificar si se envió el parámetro 'disponible' y construir la consulta
$disponible = isset($_GET['disponible']) ? $mysqli->real_escape_string($_GET['disponible']) : null;
$query = $disponible !== null ? "SELECT * FROM personas WHERE disponible='$disponible'" : "SELECT * FROM personas";

// Ejecutar la consulta
$result = $mysqli->query($query);

// Verificar si la consulta fue exitosa
if ($result) {
    $myArray = [];

    // Recorrer los resultados y agregar cada fila al array
    while ($row = $result->fetch_object()) {
        $myArray[] = $row;
    }

    // Devolver los datos en formato JSON
    echo json_encode($myArray);

    // Liberar el resultado
    $result->close();
} else {
    // Si hubo un error en la consulta
    echo json_encode(["status" => "error", "message" => "Error en la consulta a la base de datos"]);
}

// Cerrar la conexión
$mysqli->close();
?>
