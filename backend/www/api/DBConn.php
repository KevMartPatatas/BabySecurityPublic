<?php
class DBConn extends mysqli
{
    public static function newConnection() {
        return new DBConn('shuttle.proxy.rlwy.net:21578', 'root', 'fzTFRQpStXgZzwHaSOpUWqmdNsrACCGA', 'railway');

    }

    public function __construct($host, $user, $pass, $db) {
        parent::__construct($host, $user, $pass, $db);

        if(mysqli_connect_error()) {
            throw new Exception("Error de Conexion ("
                . mysqli_connect_errno()
                . ") "
                . mysqli_connect_error()
            );
        }
    }
}

