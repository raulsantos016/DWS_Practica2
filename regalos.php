<?php
include "clase_conexion.php";
include "clase_regalos.php";

$conexion = (new clase_conexion())->conectar();
$regalos = new clase_regalos($conexion);

$mensaje = "";

$listaReyes = mysqli_query($conexion, "SELECT * FROM reyes");

if (isset($_POST['insertar'])) {
    $nombre = trim($_POST['nombreRegalo']);
    $precio = trim($_POST['precioRegalo']);
    $idRey = $_POST['idRey'];

    if ($nombre === "" || $precio === "" || !is_numeric($precio) || $precio < 0 || $idRey === "") {
        $mensaje = "Por favor, completa todos los campos correctamente.";
    } else {
        $regalos->insertar($nombre, $precio, $idRey);
        $mensaje = "Se ha añadido correctamente el regalo: $nombre.";
    }
}

if (isset($_POST['borrar'])) {
    $idRegalo = $_POST['idRegalo'];
    $nombre = $_POST['nombreRegalo'] ?? '';
    $regalos->borrar($idRegalo);
    $mensaje = "Se ha borrado correctamente el regalo: $nombre.";
}

if (isset($_POST['modificar'])) {
    $idRegalo = $_POST['idRegalo'];
    $nombre = trim($_POST['nombreRegalo']);
    $precio = trim($_POST['precioRegalo']);
    $idRey = $_POST['idRey'];

    if ($nombre === "" || $precio === "" || !is_numeric($precio) || $precio < 0 || $idRey === "") {
        $mensaje = "Por favor, completa todos los campos correctamente.";
    } else {
        $regalos->modificar($idRegalo, $nombre, $precio, $idRey);
        $mensaje = "Se ha modificado correctamente el regalo: $nombre.";
    }
}

$resultado = $regalos->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Regalos</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script>
        function confirmarAccion(form) {
            let nombre = form.nombreRegalo ? form.nombreRegalo.value.trim() : '';
            let precio = form.precioRegalo ? form.precioRegalo.value.trim() : '';
            let idRey = form.idRey ? form.idRey.value : '';

            if ((nombre === "" && form.modificar) || (precio === "" && form.modificar) || (idRey === "" && form.modificar)) {
                alert("Por favor, completa todos los campos correctamente antes de modificar.");
                return false;
            }
            if ((nombre === "" && form.insertar) || (precio === "" && form.insertar) || (idRey === "" && form.insertar)) {
                alert("Por favor, completa todos los campos correctamente antes de añadir.");
                return false;
            }

            if (form.borrar && form.borrar === document.activeElement) {
                return confirm("¿Estás seguro de borrar este regalo?");
            }
            if (form.modificar && form.modificar === document.activeElement) {
                return confirm("¿Estás seguro de modificar este regalo?");
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Regalos</h1>

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
                    <th>Precio</th>
                    <th>Rey Mago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_array($resultado)) { ?>
                    <tr>
                        <form method="POST" onsubmit="return confirmarAccion(this);">
                            <td><input type="text" name="nombreRegalo" value="<?php echo htmlspecialchars($fila['nombreRegalo']); ?>"></td>
                            <td><input type="text" name="precioRegalo" value="<?php echo htmlspecialchars($fila['precioRegalo']); ?>"></td>
                            <td>
                                <select name="idRey">
                                    <?php
                                    $reyesLista = mysqli_query($conexion, "SELECT * FROM reyes");
                                    while ($r = mysqli_fetch_array($reyesLista)) {
                                        $selected = ($r['idRey'] == $fila['idReyFK']) ? "selected" : "";
                                        echo "<option value='{$r['idRey']}' $selected>{$r['nombreRey']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="idRegalo" value="<?php echo $fila['idRegalo']; ?>">
                                <input type="submit" name="modificar" value="Modificar" class="btn-modificar">
                                <input type="submit" name="borrar" value="Borrar" class="btn-borrar">
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Añadir regalo</h2>
        <form method="POST" class="form-add" onsubmit="return confirmarAccion(this);">
            <label>Nombre:</label>
            <input type="text" name="nombreRegalo">

            <label>Precio:</label>
            <input type="text" name="precioRegalo">

            <label>Rey Mago:</label>
            <select name="idRey">
                <?php while ($rey = mysqli_fetch_array($listaReyes)) { ?>
                    <option value="<?php echo $rey['idRey']; ?>">
                        <?php echo $rey['nombreRey']; ?>
                    </option>
                <?php } ?>
            </select>

            <div class="form-buttons">
                <input type="submit" name="insertar" value="Añadir" class="btn-agregar">
                <input type="reset" value="Limpiar" class="btn-limpiar">
            </div>
        </form>
    </div>
</body>

</html>