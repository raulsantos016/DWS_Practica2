<?php
include "clase_conexion.php";

$conexion = (new clase_conexion())->conectar();

$mensaje = "";
$idNinoActual = null;

if (isset($_POST['buscar'])) {
    if ($_POST['idNino'] == "") {
        $mensaje = "Por favor, selecciona un niño.";
    } else {
        $idNinoActual = $_POST['idNino'];
    }
}

if (isset($_POST['agregar'])) {

    $idNinoActual = $_POST['idNino'];
    $idRegalo = $_POST['idRegalo'];

    if ($idNinoActual <= 0 || $idRegalo <= 0) {
        $mensaje = "Por favor, selecciona un niño y un regalo válidos.";
    } else {
        $consulta = "SELECT * FROM nino_regalo WHERE idNinoFK=$idNinoActual AND idRegaloFK=$idRegalo";
        $existe = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($existe) > 0) {
            $mensaje = "Ese regalo ya está asignado a este niño.";
        } else {
            mysqli_query($conexion, "INSERT INTO nino_regalo (idNinoFK, idRegaloFK) VALUES ($idNinoActual, $idRegalo)");
            $mensaje = "Regalo añadido correctamente.";
        }
    }

    $_POST['buscar'] = true;
}

$listaNinos = mysqli_query($conexion, "SELECT * FROM ninos ORDER BY nombreNino ASC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Búsqueda de regalos</title>
    <link rel="stylesheet" href="css/estilos.css">

    <script>
        function confirmarAgregar() {
            return confirm("¿Deseas añadir este regalo al niño?");
        }
    </script>
</head>

<body>
    <div class="container">

        <h1>Búsqueda de regalos</h1>

        <div class="menu">
            <a href="index.html">Inicio</a>
            <a href="ninos.php">Niños</a>
            <a href="regalos.php">Regalos</a>
            <a href="busqueda.php">Búsqueda</a>
            <a href="reyes.php">Reyes Magos</a>
        </div>

        <?php if ($mensaje !== ""): ?>
            <div class="mensaje <?php echo (strpos($mensaje, 'Por favor') === 0 || strpos($mensaje, 'Ese regalo ya está asignado') === 0) ? 'error' : 'exito'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <h2>Seleccionar niño</h2><br>

        <form method="POST" class="selector">
            <select name="idNino">
                <option value="">-- Selecciona un niño --</option>
                <?php while ($nino = mysqli_fetch_array($listaNinos)) {
                    $selected = ($idNinoActual == $nino['idNino']) ? "selected" : "";
                ?>
                    <option value="<?php echo $nino['idNino']; ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($nino['nombreNino']); ?>
                    </option>
                <?php } ?>
            </select>
            <input type="submit" name="buscar" value="Buscar" class="btn-buscar">
        </form>

        <?php if (isset($_POST['buscar']) && $idNinoActual): ?>

            <?php
            $resNombre = mysqli_query($conexion, "SELECT nombreNino FROM ninos WHERE idNino = $idNinoActual");
            $nombreNino = "";
            if ($filaNombre = mysqli_fetch_array($resNombre)) {
                $nombreNino = $filaNombre['nombreNino'];
            }
            ?>
            <br><br>
            <h2>Regalos asignados a <?php echo htmlspecialchars($nombreNino); ?></h2>
            <br>

            <table>
                <thead>
                    <tr>
                        <th>Regalo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $regalosAsignados = mysqli_query($conexion, "
                        SELECT regalos.nombreRegalo 
                        FROM regalos
                        JOIN nino_regalo ON regalos.idRegalo = nino_regalo.idRegaloFK
                        WHERE nino_regalo.idNinoFK = $idNinoActual
                        ORDER BY regalos.nombreRegalo ASC
                    ");

                    if (mysqli_num_rows($regalosAsignados) == 0) {
                        echo "<tr><td>No tiene regalos asignados.</td></tr>";
                    } else {
                        while ($fila = mysqli_fetch_array($regalosAsignados)) {
                            echo "<tr><td>" . htmlspecialchars($fila['nombreRegalo']) . "</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

            <h3>Añadir regalo</h3>

            <form method="POST" class="form-add" onsubmit="return confirmarAgregar()">
                <input type="hidden" name="idNino" value="<?php echo $idNinoActual; ?>">

                <select name="idRegalo">
                    <option value="">-- Selecciona un regalo --</option>
                    <?php
                    $regalos = mysqli_query($conexion, "SELECT * FROM regalos ORDER BY nombreRegalo ASC");
                    while ($regalo = mysqli_fetch_array($regalos)) {
                        echo "<option value='" . $regalo['idRegalo'] . "'>" . htmlspecialchars($regalo['nombreRegalo']) . "</option>";
                    }
                    ?>
                </select>

                <input type="submit" name="agregar" value="Añadir" class="btn-agregar">
            </form>

        <?php endif; ?>
    </div>
</body>

</html>