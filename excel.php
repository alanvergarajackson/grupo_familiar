<?php

// Configurar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grupo_familiar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Datos que deseas exportar a CSV
$datos = array();

// Encabezados
$encabezados = array(
    "empleado",
    "Nombre",
    "Paterno",
    "Materno",
    "Relacion",
    "Rut",
    "nombre",
    "Apellido Paterno",
    "Apellido Materno",
    "Fecha de Nacimiento",
    "nacionalidad",
    "es carga?",
    "sexo",
    "observaciones",
    "Desde",
    "Hasta",
);

$datos[] = $encabezados;

// Realizar una consulta SQL para obtener datos de la base de datos
$sql = "SELECT * FROM grupo_familiar";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row_data = $result->fetch_assoc()) {
        $datos[] = array(
            $row_data['rut_colaborador'],
            $row_data['nombre_colaborador'],
            $row_data['paterno_colaborador'],
            $row_data['materno_colaborador'],
            $row_data['relacion'],
            $row_data['rut_carga'],
            $row_data['nombre_carga'],
            $row_data['paterno_cargas'],
            $row_data['materno_cargas'],
            $row_data['fecha_nacimiento'],
            '',
            $row_data['carga'],
            '',
            '',
            '',
            '',
        );
    }
} else {
    echo "No se encontraron resultados en la base de datos.";
}

// Generar un archivo CSV con punto y coma como delimitador
$nombreArchivo = 'datos_grupo_familiar.csv';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');

$salida = fopen('php://output', 'w');

foreach ($datos as $fila) {
    fputcsv($salida, $fila, ';'); // Usar punto y coma (;) como delimitador
}

fclose($salida);

// Cerrar la conexión a la base de datos
$conn->close();
