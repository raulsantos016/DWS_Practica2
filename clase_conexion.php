<?php
class clase_conexion
{
    public function conectar()
    {
        $conexion = mysqli_connect("localhost", "root", "PonferradinA_08", "reyes_magos");

        if (!$conexion) {
            exit("No se puede conectar: " . mysqli_connect_error());
        }

        return $conexion;
    }
}
?>
