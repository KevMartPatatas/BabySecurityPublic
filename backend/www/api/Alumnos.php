<?php

class Alumnos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function getAlumnos($grupo)
    {
        $query = "SELECT nocontrol, nombre, apellidos, sexo, status, tutor, direccion, telefono, grupo_clave FROM alumno WHERE grupo_clave = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('s', $grupo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nocontrol, $nombre, $apellidos, $sexo, $status, $tutor, $direccion, $telefono, $grupo_clave);
            while ($stmt->fetch()) {
                $alumnosObtenidos[] = [
                    'nocontrol' => $nocontrol,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'sexo' => $sexo,
                    'status' => $status,
                    'tutor' => $tutor,
                    'direccion' => $direccion,
                    'telefono' => $telefono,
                    'grupo_clave' => $grupo_clave
                ];
            }

            return json_encode(['alumnos' => $alumnosObtenidos]);
        }

        return false;
    }
}