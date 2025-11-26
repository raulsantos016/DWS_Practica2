<?php
class clase_regalos
{
    private $conexion;

    function __construct($conexionBD)
    {
        $this->conexion = $conexionBD;
    }

    // Obtener todos los regalos
    function obtenerTodos()
    {
        $consulta = "SELECT * FROM regalos ORDER BY nombreRegalo ASC";
        return mysqli_query($this->conexion, $consulta);
    }

    // Insertar un regalo
    function insertar($nombreRegalo, $precioRegalo, $idRey)
    {
        $consulta = "INSERT INTO regalos (nombreRegalo, precioRegalo, idReyFK)
                     VALUES ('$nombreRegalo', $precioRegalo, $idRey)";
        return mysqli_query($this->conexion, $consulta);
    }

    // Borrar un regalo
    function borrar($idRegalo)
    {
        $consulta = "DELETE FROM regalos WHERE idRegalo = $idRegalo";
        return mysqli_query($this->conexion, $consulta);
    }

    // Modificar un regalo
    function modificar($idRegalo, $nombreRegalo, $precioRegalo, $idRey)
    {
        $consulta = "UPDATE regalos SET 
                        nombreRegalo = '$nombreRegalo',
                        precioRegalo = $precioRegalo,
                        idReyFK = $idRey
                     WHERE idRegalo = $idRegalo";

        return mysqli_query($this->conexion, $consulta);
    }
}
?>
