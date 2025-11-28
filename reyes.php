<?php
include "clase_conexion.php";
include "clase_reyes.php";

$conexion = (new clase_conexion())->conectar();
$reyes = new clase_reyes($conexion);

$listaReyes = mysqli_query($conexion, "SELECT * FROM reyes");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reyes Magos</title>
    <link rel="stylesheet" href="css/reyes.css">
</head>

<body>
    <div class="container">
        <h1>Reyes Magos</h1>

        <div class="menu">
            <a href="index.html">Inicio</a>
            <a href="ninos.php">Niños</a>
            <a href="regalos.php">Regalos</a>
            <a href="busqueda.php">Búsqueda</a>
            <a href="reyes.php">Reyes Magos</a>
        </div>

        <?php
        while ($rey = mysqli_fetch_assoc($listaReyes)) {
            echo "<h2>" . htmlspecialchars($rey['nombreRey']) . "</h2>";

            $resultado = $reyes->regalosPorRey($rey['idRey']);
            $totalGastado = 0;

            echo "<table>
            <thead>
                <tr>
                    <th>Regalo</th>
                    <th>Niño</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>";

            while ($fila = mysqli_fetch_assoc($resultado)) {
                $totalGastado += $fila['precio'];

                echo "<tr>
                <td>" . htmlspecialchars($fila['regalo']) . "</td>
                <td>" . htmlspecialchars($fila['nino']) . "</td>
                <td>" . number_format($fila['precio'], 2, ',', '.') . " €</td>
              </tr>";
            }

            echo "</tbody></table>";

            echo "<strong class='total'>
            Total gastado: " . number_format($totalGastado, 2, ',', '.') . " €
          </strong><br><br>";
        }

        ?>
    </div>
</body>

</html>