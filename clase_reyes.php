<?php
class clase_reyes
{
    private $conexion;

    function __construct($conexionBD)
    {
        $this->conexion = $conexionBD;
    }

    function regalosPorRey($id_rey)
    {
        $consulta = "SELECT 
                        regalos.nombreRegalo AS regalo,
                        ninos.nombreNino AS nino,
                        regalos.precioRegalo AS precio
                    FROM regalos
                    JOIN nino_regalo 
                        ON regalos.idRegalo = nino_regalo.idRegaloFK
                    JOIN ninos 
                        ON ninos.idNino = nino_regalo.idNinoFK
                    WHERE regalos.idReyFK = $id_rey
                      AND ninos.buenoNino = 'Sí'";

        return mysqli_query($this->conexion, $consulta);
    }
}
