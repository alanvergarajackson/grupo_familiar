<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 50%;
            margin: 0 auto;
        }

        .success {
            color: #008000;
            font-weight: bold;
        }

        .error {
            color: #FF0000;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Resultado del Procesamiento</h1>
        <?php
        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "grupo_familiar";

        // Create a new database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the database connection
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve Colaborador's data
            $rutColaborador = strtoupper($_POST["rutColaborador"]);
            $nombreColaborador = strtoupper($_POST["nombresColaborador"]);
            $apellidoPaternoColaborador = strtoupper($_POST["apellidoPaternoColaborador"]);
            $apellidoMaternoColaborador = strtoupper($_POST["apellidoMaternoColaborador"]);

            // Loop through Grupo Familiar data
            $rutCargas = $_POST["rut"];
            $nombresCargas = $_POST["nombres"];
            $apellidoPaternoCargas = $_POST["apellidoPaterno"];
            $apellidoMaternoCargas = $_POST["apellidoMaterno"];
            $fechasNacimiento = $_POST["fechaNacimiento"];
            $relaciones = $_POST["relacion"];
            $cargas = $_POST["cargas"];
            $sexos = $_POST["sexo"];
            $nacionalidades = $_POST["nacionalidad"];

            // Prepare and execute the database insertions
            for ($i = 0; $i < count($rutCargas); $i++) {
                $rutCarga = strtoupper($rutCargas[$i]);
                $nombresCarga = strtoupper($nombresCargas[$i]);
                $apellidoPaternoCarga = strtoupper($apellidoPaternoCargas[$i]);
                $apellidoMaternoCarga = strtoupper($apellidoMaternoCargas[$i]);
                $relacionCarga = strtoupper($relaciones[$i]);
                $carga = strtoupper($cargas[$i]);
                $sexo = strtoupper($sexos[$i]);
                $nacionalidad = strtoupper($nacionalidades[$i]);

                // Preparar la consulta SQL
                $sql = "INSERT INTO grupo_familiar (rut_colaborador, nombre_colaborador, paterno_colaborador, materno_colaborador, rut_carga, nombre_carga, paterno_cargas, materno_cargas, fecha_nacimiento, relacion, carga,sexo,nacionalidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
                $stmt = $conn->prepare($sql);

                // Comprobar si la preparación de la consulta fue exitosa
                if ($stmt) {
                    // Vincular los parámetros in the correct order (including sexo)
                    $stmt->bind_param(
                        "sssssssssssss",
                        $rutColaborador,
                        $nombreColaborador,
                        $apellidoPaternoColaborador,
                        $apellidoMaternoColaborador,
                        $rutCarga,
                        $nombresCarga,
                        $apellidoPaternoCarga,
                        $apellidoMaternoCarga,
                        $fechasNacimiento[$i],
                        $relacionCarga,
                        $carga,
                        $sexo,
                        $nacionalidad

                    );

                    if ($stmt->execute()) {
                        echo '<p class="success">Datos  guardados con éxito</p>';
                    } else {
                        echo '<p class="error">Error al guardar los datos de Carga ' . $i . ': ' . $stmt->error . '</p>';
                    }
                } else {
                    echo "Error en la preparación de la consulta: " . $conn->error . "<br>";
                }
            }
        }
        $conn->close();
        // Aquí termina tu código PHP

        ?>
    </div>
</body>

</html>