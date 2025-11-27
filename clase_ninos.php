<?php
class clase_ninos
{
    private $conexion;

    function __construct($conexionBD)
    {
        $this->conexion = $conexionBD;
    }

    // Obtener todos los niños
    function obtenerTodos()
    {
        $consulta = "SELECT * FROM ninos ORDER BY nombreNino ASC";
        return mysqli_query($this->conexion, $consulta);
    }

    // Insertar un niño
    function insertar($nombreNino, $apellidosNino, $fechaNacimiento, $esBueno)
    {
        $consulta = "INSERT INTO ninos (nombreNino, apellidosNino, fechaNino, buenoNino)
                     VALUES ('$nombreNino', '$apellidosNino', '$fechaNacimiento', '$esBueno')";

        return mysqli_query($this->conexion, $consulta);
    }

    // Borrar un niño
    public function borrar($idNino)
    {
        mysqli_query($this->conexion, "DELETE FROM nino_regalo WHERE idNinoFK=$idNino");
        mysqli_query($this->conexion, "DELETE FROM ninos WHERE idNino=$idNino");
    }


    // Modificar datos de un niño
    function modificar($idNino, $nombreNino, $apellidosNino, $fechaNacimiento, $esBueno)
    {
        $consulta = "UPDATE ninos SET 
                        nombreNino = '$nombreNino',
                        apellidosNino = '$apellidosNino',
                        fechaNino = '$fechaNacimiento',
                        buenoNino = '$esBueno'
                     WHERE idNino = $idNino";

        return mysqli_query($this->conexion, $consulta);
    }
}