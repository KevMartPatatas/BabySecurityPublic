<?php
class Login
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function newLogin($username, $password)
    {
        // Validar el nombre de usuario
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]{2,9}$/', $username)) {
            return false;
        }

        // Validar la contraseña
        if (strlen($password) < 5) {
            return false;
        }

        $query = "SELECT matricula, nombre, apellidos, password, direccion, sexo, telefono, grupo_clave FROM docente WHERE matricula = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($matricula, $nombre, $apellidos, $password_db, $direccion, $sexo, $telefono, $grupo);
            $stmt->fetch();

            if ($password == $password_db) {
                // Login exitoso
                return json_encode([
                    'matricula' => $matricula,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'direccion' => $direccion,
                    'sexo' => $sexo,
                    'telefono' => $telefono,
                    'grupo' => $grupo,
                    'userIsLoggedIn' => true,
                ]);
            }
        }

        return false; // Login fallido
    }
}
