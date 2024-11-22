<?php
require_once __DIR__ . "/connection/DbConnection.php";  // Ajusta la ruta según tu estructura de carpetas

class Login
{
    private $db;

    public function __construct()
    {
        // Crear la instancia de la clase de conexión
        $this->db = (new ConnectionBd())->getConexion();
    }

    // Método para verificar las credenciales de usuario
    public function verificarLogin($usuario, $contrasena)
    {
        // Consulta SQL para verificar el usuario y obtener su rol
     $sql =
        "SELECT u.nomUsuario, r.nombre AS rol
        FROM tblusuario u
        JOIN tblrol_usuario ru ON u.nomUsuario = ru.fkNomUsuario
        JOIN tblrol r ON ru.fkIdRol = r.id
        WHERE u.nomUsuario = :usuario AND u.contrasena = :contrasena";

        try {
            // Preparar la consulta
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':contrasena', $contrasena); // Recuerda que debes usar un hash para la contraseña

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se encontró el usuario
            if ($stmt->rowCount() > 0) {
                // Obtener los datos del usuario y rol
                $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

                // Guardar los datos en la sesión
                session_start();
                $_SESSION['usuario_id'] = $usuarioData['usuario_id'];
                $_SESSION['usuario'] = $usuarioData['nomUsuario'];
                $_SESSION['rol'] = $usuarioData['rol'];
                $_SESSION['logged_in'] = true;

                return true; // Login exitoso
            } else {
                return false; // Usuario o contraseña incorrectos
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
