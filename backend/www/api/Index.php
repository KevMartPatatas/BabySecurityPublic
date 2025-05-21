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
include 'Personal.php';
include 'Grupos.php';
include 'alumnosBitacora.php';
include 'BitacoraEdit.php';
include 'actividadInsert.php';
include 'Reportes.php';
include 'ActividadInto.php';

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
$getPersonal = new Personal($conexion);
$updatePersonal = new Personal($conexion);
$getGrupos = new Grupos($conexion);
$updateAlumnos = new Alumnos($conexion);
$agregarPersonal = new Personal($conexion);
$agregarAlumnos = new Alumnos($conexion);
$bitacoraAlumnos = new alumnosBitacora($conexion);
$SelectActBitacora = new BitacoraEdit($conexion);
$UpdateBitacora= new ActividadInsert($conexion);
$subirReporte = new Reportes($conexion);
$getReportes = new Reportes($conexion);
$insertBitacora = New ActividadInto($conexion);
$agregarPersonalGrupo = New Personal($conexion);

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

    case 'getPersonal':
        $response = $getPersonal->getPersonal();

        if ($response) {
            echo $response;
        } else {
            http_response_code(407);
            echo json_encode(["message" => "Error al obtener la lista del personal"]);
        }
        break;

    case 'updatePersonal':
        $nombre = $rp["nombre"];
        $apellidos = $rp["apellidos"];
        $direccion = $rp["direccion"];
        $sexo = $rp["sexo"];
        $telefono = $rp["telefono"];
        $rol = $rp["rol"];
        $matricula = $rp["matricula"];
        $response = $updatePersonal->updatePersonal($nombre, $apellidos, $direccion, $sexo, $telefono, $rol, $matricula);

        if ($response) {
            echo $response;
        } else {
            http_response_code(408);
            echo json_encode(["message" => "Error al actualizar la personal en la base de datos"]);
        }
        break;

    case 'getGrupos':
        $response = $getGrupos->getGrupos();

        if ($response) {
            echo $response;
        } else {
            http_response_code(409);
            echo json_encode(["message" => "Error al obtener los grupos en la base de datos"]);
        }
        break;

    case 'updateAlumnos':
        $nocontrol = $rp["nocontrol"];
        $nombre = $rp["nombre"];
        $apellidos = $rp["apellidos"];
        $sexo = $rp["sexo"];
        $status = $rp["status"];
        $direccion = $rp["direccion"];
        $clave_grupo = $rp["clave_grupo"];
        $tutor_nombre = $rp["tutor_nombre"];
        $tutor_apellidos = $rp["tutor_apellidos"];
        $telefono = $rp["telefono"];

        $response = $updateAlumnos->updateAlumno($nombre, $apellidos, $sexo, $status, $direccion, $clave_grupo, $tutor_nombre, $tutor_apellidos, $telefono, $nocontrol);

        if ($response) {
            echo $response;
        } else {
            http_response_code(409);
            echo json_encode(["message" => "Error al obtener los grupos en la base de datos"]);
        }
        break;

    case 'agregarDocente':
        $nombre = $rp["nombre"];
        $apellidos = $rp["apellidos"];
        $matricula = $rp["matricula"];
        $password = $rp["password"];
        $rol = $rp["rol"];
        $grupo = $rp["grupo"];
        $direccion = $rp["direccion"];
        $sexo = $rp["sexo"];
        $telefono = $rp["telefono"];

        $response = $agregarPersonal->agregarPersonal($nombre, $apellidos, $matricula, $password, $rol, $grupo, $direccion, $sexo, $telefono);
        $response = $agregarPersonalGrupo->agregarGrupo($grupo, $matricula);

        if ($response) {
            echo $response;
        } else {
            http_response_code(410);
            echo json_encode(["message" => "Error al obtener los grupos en la base de datos"]);
        }
        break;

    case 'agregarAlumno':
        $nocontrol = $rp["nocontrol"];
        $nombre = $rp["nombre"];
        $apellidos = $rp["apellidos"];
        $direccion = $rp["direccion"];
        $sexo = $rp["sexo"];
        $grupo = $rp["grupo"];
        $tutor_nombre = $rp["tutor_nombre"];
        $tutor_apellidos = $rp["tutor_apellidos"];
        $telefono = $rp["telefono"];

        $response = $agregarAlumnos->agregarAlumno($nocontrol, $nombre, $apellidos, $direccion, $sexo, $grupo, $tutor_nombre, $tutor_apellidos, $telefono);

        if ($response) {
            echo $response;
        } else {
            http_response_code(410);
            echo json_encode(["message" => "Error al obtener los grupos en la base de datos"]);
        }
        break;

    case 'getBitacora':
        $clave_grupo = $rp["clave_grupo"];
        $response = $bitacoraAlumnos->getBitacora($clave_grupo);

        if ($response) {
            echo $response;
        } else {
            http_response_code(411);
            echo json_encode(["message" => "Error al obtener la lista en la base de datos"]);
        }
        break;

    case 'SelectActBitacora':
        $response = $SelectActBitacora->SelectActBitacora();

        if ($response) {
            echo $response;
        } else {
            http_response_code(412);
            echo json_encode(["message" => "Error al obtener la lista en la base de datos"]);
        }
        break;

    case 'updateBitacora':
        $fecha= $rp["fecha"];
        $observaciones=$rp["observaciones"];
        $nombre_actividad =$rp["nombre_actividad"];
        $clave_bitacora=$rp["clave_bitacora"];
        $response = $UpdateBitacora->updateBitacora($fecha,$observaciones,$nombre_actividad,$clave_bitacora);

        if ($response) {
            echo $response;
        } else {
            http_response_code(406);
            echo json_encode(["message" => "Error al obtener la lista en la base de datos"]);
        }
        break;

    case 'subirReporte':
        $para = $rp["para"];
        $para_nombre = $rp["para_nombre"];
        $por = $rp["por"];
        $por_nombre = $rp["por_nombre"];
        $titulo = $rp["titulo"];
        $contenido = $rp["contenido"];
        $response = $subirReporte->subirReporte($para, $para_nombre, $por, $por_nombre, $titulo, $contenido);

        if ($response) {
            echo $response;
        } else {
            http_response_code(414);
            echo json_encode(["message" => "Error al obtener la lista en la base de datos"]);
        }
        break;

    case 'getReportes':
        $response = $getReportes->getReportes();

        if ($response) {
            echo $response;
        } else {
            http_response_code(415);
            echo json_encode(["message" => "Error al obtener la lista en la base de datos"]);
        }
        break;

    case 'insertBitacora':
        $clave_actividad= $rp["clave_actividad"];
        $fecha=$rp["fecha"];
        $alumno =$rp["alumno"];
        $observaciones=$rp["observaciones"];
        $response = $insertBitacora->insertBitacora($clave_actividad,$fecha,$alumno,$observaciones);

        if ($response) {
            echo $response;
        } else {
            http_response_code(406);
            echo json_encode(["message" => "Error al obtener la lista en la base de datos"]);
        }
        break;



    default:
        http_response_code(402);
        echo json_encode(["message" => "Comando no encontrado"]);
}
