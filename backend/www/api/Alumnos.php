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
                     a.tutor_nombre, a.tutor_apellidos, a.direccion, a.telefono_tutor, a.clave_grupo
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
            $stmt->bind_result($nocontrol, $nombre, $apellidos, $sexo, $status, $tutor, $tutor_apellidos, $direccion, $telefono, $clave_grupo);

            $alumnosObtenidos = [];

            while ($stmt->fetch()) {
                $alumnosObtenidos[] = [
                    'nocontrol' => $nocontrol,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'sexo' => $sexo,
                    'status' => $status,
                    'tutor' => $tutor,
                    'tutor_apellidos' => $tutor_apellidos,
                    'direccion' => $direccion,
                    'telefono' => $telefono,
                    'clave_grupo' => $clave_grupo
                ];
            }

            return json_encode(['alumnos' => $alumnosObtenidos]);
        }

        return json_encode(['alumnos' => []]);
    }


    public function updateAlumno($nombre, $apellidos, $sexo, $status, $direccion, $clave_grupo, $tutor_nombre, $tutor_apellidos, $telefono, $nocontrol)
    {
        $query = "UPDATE alumnos SET nombre = ?, apellidos = ?, sexo = ?, status = ?, direccion = ?, clave_grupo = ?, tutor_nombre = ?, tutor_apellidos = ?, telefono_tutor = ?
                WHERE no_control = ?";
        $stmt = $this->conexion->prepare($query);
        if (!$stmt) {
            return json_encode(['error' => 'Error al preparar la consulta']);
        }

        $stmt->bind_param("ssssssssss", $nombre, $apellidos, $sexo, $status, $direccion, $clave_grupo, $tutor_nombre, $tutor_apellidos, $telefono, $nocontrol);

        if (!$stmt->execute()) {
            return json_encode(['error' => 'Error al ejecutar la consulta']);
        }

        // Verifica si alguna fila fue afectada
        if ($stmt->affected_rows > 0) {
            return json_encode(['mensaje' => ['Actualización exitosa']]);
        } else {
            return json_encode(['mensaje' => ['No se modificó ningún registro']]);
        }


    }


    public function agregarAlumno($nocontrol, $nombre, $apellidos, $direccion, $sexo, $grupo, $tutor_nombre, $tutor_apellidos, $telefono)
    {
        $status = "activo";
        $query = "INSERT INTO alumnos (no_control, nombre, apellidos, sexo, status, tutor_nombre, tutor_apellidos, direccion, telefono_tutor, clave_grupo) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($query);

        if (!$stmt) {
            // error al preparar la consulta
            return json_encode(['error' => 'Error al preparar la consulta']);
        }

        $stmt->bind_param('ssssssssss', $nocontrol, $nombre, $apellidos, $sexo, $status, $tutor_nombre, $tutor_apellidos, $direccion, $telefono, $grupo);
        if (!$stmt->execute()) {
            // error en la ejecución de la consulta
            return json_encode(['error' => 'Error al ejecutar la consulta']);
        }
        return json_encode(['mensaje' => ['Registro exitoso']]);
    }

}