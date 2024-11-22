<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

// Controladores
$objControlUsuario = new ControlEntidad('tblusuario');
$arregloUsuarios = $objControlUsuario->listar();

$objControlRolUsu = new ControlEntidad('tblrol_usuario');
$arregloRolesUsu = $objControlRolUsu->listar();

$objControlRol = new ControlEntidad('tblrol');
$arregloRoles = $objControlRol->listar();

$boton = $_POST['bt'] ?? '';
$datosUsuario = []; // Inicializamos el arreglo de datos del usuario

switch ($boton) {
    case 'Agregar':
        $campos = ["nomUsuario", "contrasena"];
        foreach ($campos as $campo) {
            $datosUsuario[$campo] = $_POST[$campo] ?? '';
        }

        $objUsuario = new Entidad($datosUsuario);
        $objControlUsuario->guardar($objUsuario);

        // Obtener el ID del usuario recién creado
        $buscarPorId = $objControlUsuario->buscarPorId("nomUsuario", $datosUsuario['nomUsuario']);

        // Asignar el rol al usuario
        $objControlRolUsu->guardar(new Entidad([
            "fkNomUsuario" => $buscarPorId->nomUsuario,
            "fkIdRol" => $_POST["id"]
        ]));

        header('Location: usuarios.php');
        exit;

    case 'Borrar':
        if (isset($_POST['nomUsuario'])) {
            $nomUsuario = $_POST['nomUsuario'];
            $objControlUsuario->borrar('nomUsuario', $nomUsuario);

            // Eliminar también en la tabla intermedia (tblrol_usuario)
            $objControlRolUsu->borrar('fkNomUsuario', $nomUsuario);

            header('Location: usuarios.php'); // Redirigir después de borrar
            exit;
        }
        break;

    case 'Editar':
        if (isset($_POST['nomUsuario'])) {
            $nomUsuario = $_POST['nomUsuario'];
            $usuario = $objControlUsuario->buscarPorId('nomUsuario', $nomUsuario);

            // Llenamos los datos del usuario para edición
            $datosUsuario = [
                'nomUsuario' => $usuario->__get('nomUsuario'),
                'contrasena' => $usuario->__get('contrasena'),
            ];

            // Obtener el rol actual del usuario desde la tabla intermedia
            $rolUsuario = $objControlRolUsu->buscarPorId('fkNomUsuario', $nomUsuario);

            // Verifica que se ha encontrado el rol
            if ($rolUsuario) {
                $idRolUsuario = $rolUsuario->__get('fkIdRol');
                $datosUsuario['id'] = $idRolUsuario; // Guardamos el id del rol en los datos del usuario
            }
        }
        break;

    case 'Actualizar':
        if (isset($_POST['nomUsuario'])) {
            $nomUsuario = $_POST['nomUsuario'];
            $campos = ["nomUsuario", "contrasena"];
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";


            // Recoger los campos del formulario
            foreach ($campos as $campo) {
                $datosUsuario[$campo] = $_POST[$campo] ?? '';
            }

            var_dump($datosUsuario);

            // Actualizamos la entidad del usuario
            $objUsuario = new Entidad($datosUsuario);
            $objControlUsuario->modificar('nomUsuario', $nomUsuario, $objUsuario);

            
            // Verificar si se ha seleccionado un nuevo rol y actualizarlo
            if (isset($_POST['id'])) {
                // Si se ha seleccionado un rol, lo actualizamos en la tabla intermedia
               $objControlRolUsu->
                modificar('fkNomUsuario', $nomUsuario, new Entidad([
                    "fkNomUsuario" => $nomUsuario,
                    "fkIdRol" => $_POST['id'] // El nuevo rol seleccionado
                ]));
            }

            // Redirigir a la lista de usuarios después de actualizar
            header('Location: usuarios.php');
            exit;
        }
        break;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Usuarios</title>
</head>

<body>
    <h1><ins>Usuarios</ins></h1>

    <div class="users-form">
        <form method="POST" action="#">
            <h2><?php echo isset($datosUsuario['nomUsuario']) ? 'Actualizar Usuario' : 'Crear Usuario'; ?></h2>


            <input type="text" name="nomUsuario" placeholder="Nombre de usuario" value="<?php echo $datosUsuario['nomUsuario'] ?? ''; ?>" required>
            <input type="password" name="contrasena" placeholder="Contraseña" value="<?php echo $datosUsuario['contrasena'] ?? ''; ?>" required>

            <select name="id" required>
                <option value="">Seleccione un rol</option>
                <?php foreach ($arregloRoles as $rol): ?>
                    <option value="<?= $rol->__get('id') ?>" <?= (isset($datosUsuario['id']) && $datosUsuario['id'] == $rol->__get('id')) ? 'selected' : '' ?>>
                        <?= $rol->__get('nombre') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="bt" value="<?php echo isset($datosUsuario['nomUsuario']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Usuarios Creados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arregloUsuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario->__get('nomUsuario') ?></td>
                        <td><?= $usuario->__get('contrasena') ?></td>
                        <?php
                        // Obtener el rol asociado al usuario
                        $rolUsuario = $objControlRolUsu->buscarPorId('fkNomUsuario', $usuario->__get('nomUsuario'));

                        // Obtener el nombre del rol
                        $rolNombre = '';
                        if ($rolUsuario) {
                            $rolId = $rolUsuario->__get('fkIdRol');
                            $rol = $objControlRol->buscarPorId('id', $rolId);
                            $rolNombre = $rol ? $rol->__get('nombre') : 'Rol no encontrado';
                        }
                        ?>
                        <td><?= $rolNombre ?></td>
                        <td>
                            <form method="POST" action="#" style="display:inline;">
                                <input type="hidden" name="nomUsuario" value="<?= $usuario->__get('nomUsuario') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                            <form method="POST" action="#" style="display:inline;">
                                <input type="hidden" name="nomUsuario" value="<?= $usuario->__get('nomUsuario') ?>">
                                <input type="submit" name="bt" value="Borrar" class="users-table--delete" onclick="return confirm('¿Está seguro de que desea borrar este usuario?');">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>