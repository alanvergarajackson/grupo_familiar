<!DOCTYPE html>
<html lang="es-CL">

<head>
    <title>Formulario Grupo Familiar</title>
    <meta charset="UTF-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        .form-group {
            margin-bottom: 10px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <script>
        // Función para inicializar el datepicker
        function inicializarDatepicker() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
        }

        // Función para agregar un nuevo campo de RUT, Nombres, Apellido Paterno, Apellido Materno, Fecha de Nacimiento, Sexo, Nacionalidad, Relación y Cargas en la misma línea
        function agregarCampo() {
            var formulario = document.getElementById('formulario');
            var campos = formulario.querySelectorAll(".form-group");
            var ultimoCampo = campos[campos.length - 1];
            var nuevoCampo = ultimoCampo.cloneNode(true);

            // Limpia los valores de los campos clonados
            nuevoCampo.querySelector("input[name='rut[]']").value = "";
            nuevoCampo.querySelector("input[name='nombres[]']").value = "";
            nuevoCampo.querySelector("input[name='apellidoPaterno[]']").value = "";
            nuevoCampo.querySelector("input[name='apellidoMaterno[]']").value = "";

            // Agrega el campo de "Fecha de Nacimiento" con un calendario
            var fechaNacimientoDiv = nuevoCampo.querySelector(".fecha-nacimiento");
            fechaNacimientoDiv.innerHTML = '<label for="fechaNacimiento">Fecha de Nacimiento (yyyy-mm-dd):</label>' +
                '<input type="text" class="form-control datepicker" name="fechaNacimiento[]" onblur="validateDateInput(this)">';

            // Agrega el campo "Sexo" como un select
            var sexoDiv = nuevoCampo.querySelector(".sexo");
            sexoDiv.innerHTML = '<label for="sexo">Sexo:</label>' +
                '<select class="form-control" name="sexo[]">' +
                '<option value="" selected></option>' +
                '<option value="masculino">Masculino</option>' +
                '<option value="femenino">Femenino</option>' +
                '<option value="no-especificado">No especificado</option>' +
                '</select>';

            // Agrega el campo "Nacionalidad" como un select con las opciones
            var nacionalidadDiv = nuevoCampo.querySelector(".nacionalidad");
            nacionalidadDiv.innerHTML = '<label for="nacionalidad">Nacionalidad:</label>' +
                '<select class="form-control" name="nacionalidad[]">' +
                '<option value="" selected></option>' +
                '<option value="chilena">Chilena</option>' +
                '<option value="argentina">Argentina</option>' +
                '<option value="boliviana">Boliviana</option>' +
                '<option value="brasileña">Brasileña</option>' +
                '<option value="colombiana">Colombiana</option>' +
                '<option value="ecuatoriana">Ecuatoriana</option>' +
                '<option value="paraguaya">Paraguaya</option>' +
                '<option value="peruana">Peruana</option>' +
                '<option value="uruguaya">Uruguaya</option>' +
                '<option value="otra">Otra</option>' +
                '</select>';

            // Agrega el campo "Cargas" como un select con las opciones "Sí" y "No"
            var cargasDiv = nuevoCampo.querySelector(".cargas");
            cargasDiv.innerHTML = '<label for "cargas">¿Es carga?</label>' +
                '<select class="form-control" name="cargas[]">' +
                '<option value="" selected></option>' +
                '<option value="Si">Sí</option>' +
                '<option value="No">No</option>' +
                '</select>';

            formulario.querySelector(".row").appendChild(nuevoCampo);

            // Inicializa el datepicker en el nuevo campo
            inicializarDatepicker();
        }

        // Función para quitar el campo de RUT, Nombres, Apellido Paterno, Apellido Materno, Fecha de Nacimiento, Sexo, Nacionalidad, Relación y Cargas
        function quitarCampo() {
            var formulario = document.getElementById('formulario');
            var campos = formulario.querySelectorAll(".form-group");

            // Asegúrate de que quede al menos un campo de RUT
            if (campos.length > 1) {
                formulario.querySelector(".row").removeChild(campos[campos.length - 1]);
            }
        }

        // Función para validar que los campos no estén vacíos
        function validateForm() {
            var campos = document.querySelectorAll("input[name='rut[]'], input[name='nombres[]'], input[name='apellidoPaterno[]'], input[name='apellidoMaterno[]'], select[name='fechaNacimiento[]'], select[name='sexo[]'], select[name='nacionalidad[]'], select[name='relacion[]'], select[name='cargas[]']");

            var isFormValid = true;
            var errorMessage = "Se encontraron los siguientes errores:\n";

            for (var i = 0; i < campos.length; i++) {
                var campo = campos[i];

                if (campo.value.trim() === "") {
                    errorMessage += "- Todos los campos son obligatorios. Por favor, llénelos antes de enviar el formulario.\n";
                    isFormValid = false;
                } else if (campo.tagName === "SELECT" && campo.value === "") {
                    errorMessage += "- Todos los campos de selección son obligatorios. Por favor, seleccione una opción.\n";
                    isFormValid = false;
                }

                if (campo.tagName === "INPUT") {
                    // Convierte el valor del campo en mayúsculas
                    campo.value = campo.value.toUpperCase();
                }
            }

            if (!isFormValid) {
                alert(errorMessage);
                return false; // Evita el envío del formulario si hay errores
            }

            return true;
        }

        function validateDateInput(input) {
            const date = input.value;
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;

            if (!date.match(dateRegex)) {
                alert("Formato de fecha de nacimiento incorrecto. Debe estar en formato yyyy-mm-dd.");
                input.value = "";
            }
        }

        // Esta función se ejecuta cuando el documento está listo
        $(document).ready(function() {
            inicializarDatepicker();
        });
    </script>
</head>

<body>
    <form action="procesar.php" method="post" class="border p-3" onsubmit="return validateForm()">
        <div id="formulario">
            <div class="col-md-6">
                <h2>Grupo Familiar del Colaborador</h2>
                <div class="container mt-4">
                    <div class="form-group">
                        <div class="row form-row">
                            <label for="rut">RUT:</label>
                            <input type="text" class="form-control" name="rut[]">
                            <label for="nombres">Nombres:</label>
                            <input type="text" class="form-control" name="nombres[]">
                            <label for="apellidoPaterno">Apellido Paterno:</label>
                            <input type="text" class="form-control" name="apellidoPaterno[]">
                            <label for="apellidoMaterno">Apellido Materno:</label>
                            <input type="text" class="form-control" name="apellidoMaterno[]">
                            <div class="fecha-nacimiento">
                                <label for="fechaNacimiento">Fecha de Nacimiento (yyyy-mm-dd):</label>
                                <input type="text" class="form-control datepicker" name="fechaNacimiento[]" onblur="validateDateInput(this)">
                            </div>
                            <div class="sexo">
                                <label for="sexo">Sexo:</label>
                                <select class="form-control" name="sexo[]">
                                    <option value="" selected></option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="no-especificado">No especificado</option>
                                </select>
                            </div>
                            <div class="nacionalidad">
                                <label for="nacionalidad">Nacionalidad:</label>
                                <select class="form-control" name="nacionalidad[]">
                                    <option value="" selected></option>
                                    <option value="chilena">Chilena</option>
                                    <option value="argentina">Argentina</option>
                                    <option value="boliviana">Boliviana</option>
                                    <option value="brasileña">Brasileña</option>
                                    <option value="colombiana">Colombiana</option>
                                    <option value="ecuatoriana">Ecuatoriana</option>
                                    <option value="paraguaya">Paraguaya</option>
                                    <option value="peruana">Peruana</option>
                                    <option value="uruguaya">Uruguaya</option>
                                    <option value="otra">Otra</option>
                                </select>
                            </div>
                            <div class="relacion">
                                <label for="relacion">Relación:</label>
                                <select class="form-control" name="relacion[]">
                                    <option value="" selected>Seleccionar</option>
                                    <option value="conyuge">Cónyuge</option>
                                    <option value="hijo">Hijo</option>
                                    <option value="estudiando">Hijo entre 18 y 24 años estudiando</option>
                                    <option value="mayor65">Ascendiente mayor a 65 años</option>
                                    <option value="nieto">Nieto</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="cargas">
                                <label for "cargas">¿Es carga?</label>
                                <select class="form-control" name="cargas[]">
                                    <option value="" selected></option>
                                    <option value="Si">Sí</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-danger" onclick="quitarCampo()">Quitar Campo</button>
        </div>
        <br>
        <input type="hidden" name="rutColaborador" value="<?php echo $_POST['rutColaborador']; ?>">
        <input type="hidden" name="nombresColaborador" value="<?php echo $_POST['nombresColaborador']; ?>">
        <input type="hidden" name="apellidoPaternoColaborador" value="<?php echo $_POST['apellidoPaternoColaborador']; ?>">
        <input type="hidden" name="apellidoMaternoColaborador" value="<?php echo $_POST['apellidoMaternoColaborador']; ?>">
        <button type="button" class="btn btn-success" onclick="agregarCampo()">Agregar Campo</button>
        <button type="submit" class="btn btn-primary">Enviar Formulario</button>
    </form>
</body>

</html>