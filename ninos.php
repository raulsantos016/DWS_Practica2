<?php
include "clase_conexion.php";
include "clase_ninos.php";

$conexion = (new clase_conexion())->conectar();
$ninos = new clase_ninos($conexion);

$mensaje = "";

if (isset($_POST['insertar'])) {
    $nombre = trim($_POST['nombreNino']);
    $apellidos = trim($_POST['apellidosNino']);
    $fecha = $_POST['fechaNino'];
    $bueno = $_POST['buenoNino'];
    $hoy = date("Y-m-d");

    if ($nombre === "" || $apellidos === "" || $fecha === "" || ($fecha > $hoy)) {
        $mensaje = "Por favor, completa todos los campos correctamente.";
    } else {
        $ninos->insertar($nombre, $apellidos, $fecha, $bueno);
        $mensaje = "Se ha añadido correctamente a $nombre $apellidos.";
    }
}

if (isset($_POST['borrar'])) {
    $idNino = $_POST['idNino'];
    $nombre = $_POST['nombreNino'];
    $ninos->borrar($idNino);
    $mensaje = "Se ha borrado correctamente a $nombre.";
}

if (isset($_POST['modificar'])) {
    $idNino = $_POST['idNino'];
    $nombre = trim($_POST['nombreNino']);
    $apellidos = trim($_POST['apellidosNino']);
    $fecha = $_POST['fechaNino'];
    $bueno = $_POST['buenoNino'];
    $hoy = date("Y-m-d");

    if ($nombre === "" || $apellidos === "" || $fecha === "" || ($fecha > $hoy)) {
        $mensaje = "Por favor, completa todos los campos correctamente.";
    } else {
        $ninos->modificar($idNino, $nombre, $apellidos, $fecha, $bueno);
        $mensaje = "Se ha modificado correctamente a $nombre $apellidos.";
    }
}

$resultado = $ninos->obtenerTodos();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Niños</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script>
        function confirmarAccion(form) {
            let nombre = form.nombreNino ? form.nombreNino.value.trim() : '';
            let apellidos = form.apellidosNino ? form.apellidosNino.value.trim() : '';
            let fecha = form.fechaNino ? form.fechaNino.value : '';

            if ((nombre === "" && form.modificar) || (apellidos === "" && form.modificar) || (fecha === "" && form.modificar)) {
                alert("Por favor, completa todos los campos correctamente antes de modificar.");
                return false;
            }

            if(form.borrar && form.borrar === document.activeElement) {
                return confirm("¿Estás seguro de borrar este niño?");
            }
            if(form.modificar && form.modificar === document.activeElement) {
                return confirm("¿Estás seguro de modificar este niño?");
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Niños</h1>

        <div class="menu">
            <a href="index.html">Inicio</a>
            <a href="ninos.php">Niños</a>
            <a href="regalos.php">Regalos</a>
            <a href="busqueda.php">Búsqueda</a>
            <a href="reyes.php">Reyes Magos</a>
        </div>

        <?php if ($mensaje !== ""): ?>
            <div class="mensaje <?php echo strpos($mensaje, 'Por favor') === 0 ? 'error' : 'exito'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Fecha nacimiento</th>
                    <th>Bueno (Sí/No)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_array($resultado)) { ?>
                    <tr>
                        <form method="POST" onsubmit="return confirmarAccion(this);">
                            <td><input type="text" name="nombreNino" value="<?php echo htmlspecialchars($fila['nombreNino']); ?>"></td>
                            <td><input type="text" name="apellidosNino" value="<?php echo htmlspecialchars($fila['apellidosNino']); ?>"></td>
                            <td><input type="date" name="fechaNino" value="<?php echo $fila['fechaNino']; ?>"></td>
                            <td>
                                <select name="buenoNino">
                                    <option value="Sí" <?php if ($fila['buenoNino'] == "Sí") echo "selected"; ?>>Sí</option>
                                    <option value="No" <?php if ($fila['buenoNino'] == "No") echo "selected"; ?>>No</option>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="idNino" value="<?php echo $fila['idNino']; ?>">
                                <input type="submit" name="modificar" value="Modificar" class="btn-modificar">
                                <input type="submit" name="borrar" value="Borrar" class="btn-borrar">
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Añadir niño</h2>
        <form method="POST" class="form-add" onsubmit="return confirmarAccion(this);">
            <label>Nombre:</label>
            <input type="text" name="nombreNino">

            <label>Apellidos:</label>
            <input type="text" name="apellidosNino">

            <label>Fecha de nacimiento:</label>
            <input type="date" name="fechaNino">

            <label>Bueno (Sí/No):</label>
            <select name="buenoNino">
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>

            <div class="form-buttons">
                <input type="submit" name="insertar" value="Añadir" class="btn-agregar">
                <input type="reset" value="Limpiar" class="btn-limpiar">
            </div>
        </form>
    </div>
</body>

</html>
