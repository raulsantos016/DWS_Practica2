<?php 
include "clase_conexion.php";
include "clase_reyes.php";

$conexion = (new clase_conexion())->conectar();
$reyes = new clase_reyes($conexion);

// Lista completa de reyes
$lista = mysqli_query($conexion, "SELECT * FROM reyes ORDER BY nombreRey ASC");
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
        while ($rey = mysqli_fetch_array($lista)) {

            echo "<h2>" . htmlspecialchars($rey['nombreRey']) . "</h2>";

            // Regalos asociados a este rey
            $resultado = $reyes->regalosPorRey($rey['idRey']);
            $totalGastado = 0;

            echo "<table>";
            echo "<thead>
                    <tr>
                        <th>Regalo</th>
                        <th>Niño</th>
                        <th>Precio</th>
                    </tr>
                  </thead>
                  <tbody>";

            while ($fila = mysqli_fetch_array($resultado)) {

                $esBueno = ($fila['bueno'] === "Sí");  // ya validado porque es un <select>
                $precioFormateado = number_format($fila['precio'], 2, ',', '.');

                // Si es malo → fondo rojo suave
                $style = $esBueno ? "" : "style='background-color: #c0392b66;'";

                echo "<tr $style>
                        <td>" . htmlspecialchars($fila['regalo']) . "</td>
                        <td>" . htmlspecialchars($fila['nino']) . "</td>
                        <td>$precioFormateado €</td>
                      </tr>";

                // Solo suma los buenos
                if ($esBueno) {
                    $totalGastado += $fila['precio'];
                }
            }

            echo "</tbody></table>";

            echo "<strong class='total'>
                    Total gastado SOLO en niños buenos: 
                    " . number_format($totalGastado, 2, ',', '.') . " €
                  </strong><br><br>";
        }
        ?>
    </div>
</body>

</html>
