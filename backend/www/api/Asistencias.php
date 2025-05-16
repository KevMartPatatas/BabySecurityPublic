<?php
date_default_timezone_set('America/Mexico_City');

class Asistencias
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Recibe un array de asistencias
    public function guardarAsistencia($asistencias)
    {
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $query = "INSERT INTO asistencias (no_control, fecha, hora, estado_asistencia)
          VALUES (?, ?, ?, ?)
          ON DUPLICATE KEY UPDATE estado_asistencia = VALUES(estado_asistencia), hora = VALUES(hora)";

        $stmt = $this->conexion->prepare($query);

        if (!$stmt) {
            // error al preparar la consulta
            return false;
        }

        foreach ($asistencias as $asistencia) {
            $no_control = $asistencia['no_control'];
            $estado = $asistencia['estado_asistencia'];

            $stmt->bind_param('ssss', $no_control, $fecha, $hora, $estado);
            if (!$stmt->execute()) {
                // error en la ejecución de la consulta
                return false;
            }
        }
        // si todo salió bien
        return json_encode(["message" => "Asistencias guardadas correctamente"]);
    }

    public function obtenerAsistencias($clave_grupo)
    {
        $query = "SELECT a.no_control, a.nombre, a.apellidos, asi.fecha, asi.hora, asi.estado_asistencia
FROM alumnos a
JOIN (
    SELECT no_control, MAX(fecha) AS ultima_fecha
    FROM asistencias
    GROUP BY no_control
) ult_asi ON a.no_control = ult_asi.no_control
JOIN asistencias asi ON a.no_control = asi.no_control AND asi.fecha = ult_asi.ultima_fecha
WHERE a.clave_grupo = ?
ORDER BY a.apellidos;
";

        $stmt = $this->conexion->prepare($query);
        if (!$stmt) {
            return json_encode(['error' => 'Error al preparar la consulta']);
        }

        $stmt->bind_param('s', $clave_grupo);
        if (!$stmt->execute()) {
            return json_encode(['error' => 'Error al ejecutar la consulta']);
        }

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nocontrol, $nombre, $apellidos, $fecha, $hora, $estado);

            $listaAsistencia = [];

            while ($stmt->fetch()) {
                $listaAsistencia[] = [
                    'nocontrol' => $nocontrol,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'estado' => $estado
                ];
            }

            return json_encode(['listaAsistencia' => $listaAsistencia]);
        }

        return json_encode(['listaAsistencia' => []]);
    }

}
