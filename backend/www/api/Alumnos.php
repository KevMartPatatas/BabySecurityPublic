<?php

class Alumnos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function getAlumnos($matricula)
    {
        $query = "SELECT a.no_control, a.nombre, a.apellidos, a.sexo, a.status, 
                     a.tutor_nombre, a.direccion, a.telefono_tutor, a.clave_grupo 
              FROM alumnos a
              JOIN grupos g ON a.clave_grupo = g.clave_grupo 
              WHERE g.matricula_docente = ?";

        $stmt = $this->conexion->prepare($query);
        if (!$stmt) {
            return json_encode(['error' => 'Error al preparar la consulta']);
        }

        $stmt->bind_param('s', $matricula);

        if (!$stmt->execute()) {
            return json_encode(['error' => 'Error al ejecutar la consulta']);
        }

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nocontrol, $nombre, $apellidos, $sexo, $status, $tutor, $direccion, $telefono, $clave_grupo);

            $alumnosObtenidos = [];

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
                    'clave_grupo' => $clave_grupo
                ];
            }

            return json_encode(['alumnos' => $alumnosObtenidos]);
        }

        return json_encode(['alumnos' => []]);
    }

}