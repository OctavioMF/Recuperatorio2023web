<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

// Suprimir mensajes de advertencia para evitar interferencias en la respuesta JSON
ini_set('display_errors', 0);
error_reporting(0);

// Conectar a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'cordenate');

// Obtener el cuerpo de la solicitud y decodificar el JSON
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($conexion) {
    // Asignar valores de $data a las variables y prevenir inyecciones SQL
    $apellido = mysqli_real_escape_string($conexion, $data['apellido']);
    $nombre = mysqli_real_escape_string($conexion, $data['nombre']);
    $celular = mysqli_real_escape_string($conexion, $data['celular']);
    $latitud = mysqli_real_escape_string($conexion, $data['latitud']);
    $longitud = mysqli_real_escape_string($conexion, $data['longitud']);
    $disponible = mysqli_real_escape_string($conexion, $data['disponible']);
	$var_tiempo = mysqli_real_escape_string($conexion, $data['var_tiempo']);

    // Preparar y ejecutar la instrucción SQL
    $instruccion = "INSERT INTO personas (apellido, nombre, celular, latitud, longitud, disponible, var_temp) 
                    VALUES ('$apellido', '$nombre', '$celular', '$latitud', '$longitud', '$disponible', '$var_tiempo')";

    if (mysqli_query($conexion, $instruccion)) {
        // Devolver JSON de éxito
        echo json_encode(["status" => "success", "message" => "Datos guardados correctamente"]);
    } else {
        // Error de ejecución de consulta SQL
        echo json_encode(["status" => "error", "message" => "No se pudo guardar, verifique el envío de datos"]);
    }

    mysqli_close($conexion); // Cerrar conexión
} else {
    // Error en la conexión a la base de datos
    echo json_encode(["status" => "error", "message" => "Error en la conexión con la base de datos"]);
}
?>
