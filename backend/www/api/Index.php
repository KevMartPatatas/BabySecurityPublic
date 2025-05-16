<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');

// Manejo de solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'DBConn.php';
include 'Login.php';
include 'Alumnos.php';
include 'Asistencias.php';

$rp = json_decode(file_get_contents('php://input'), true);
if (!$rp || !isset($rp["option"])) {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
    exit();
}

$conexion = DBConn::newConnection();
$login = new Login($conexion);
$getAlumnos = new Alumnos($conexion);
$guardarAsistencia = new Asistencias($conexion);
$obtenerAsistencias = new Asistencias($conexion);


$option = $rp["option"];

switch ($option) {
    case 'login':
        $user = $rp["matricula"];
        $pass = $rp["password"];
        $response = $login->newLogin($user, $pass);

        if ($response) {
            echo $response;
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Usuario o contraseña incorrecta"]);
        }
        break;

    case 'getAlumnos':
        $matricula = $rp["matricula"];
        $response = $getAlumnos->getAlumnos($matricula);

        if ($response) {
            echo $response;
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Error al obtener informacion de los alumnos en la base de datos"]);
        }
        break;

    case 'guardarAsistencia':
        $asistencias = $rp["asistencias"];
        $response = $guardarAsistencia->guardarAsistencia($asistencias);

        if ($response) {
            echo $response;
        } else {
            http_response_code(405);
            echo json_encode(["message" => "Error al guardar las asistencias en la base de datos"]);
        }
        break;

    case 'getAsistencias':
        $clave_grupo = $rp["clave_grupo"];
        $response = $obtenerAsistencias->obtenerAsistencias($clave_grupo);

        if ($response) {
            echo $response;
        } else {
            http_response_code(406);
            echo json_encode(["message" => "Error al obtener las asistencias en la base de datos"]);
        }
        break;



    default:
        http_response_code(402);
        echo json_encode(["message" => "Comando no encontrado"]);
}
