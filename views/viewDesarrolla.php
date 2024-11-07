<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

$objControlProyecto = new ControlEntidad('proyecto');
$arregloListar = $objControlProyecto->listar();

$objControlDesarrolla = new ControlEntidad('desarrolla');
$arregloListarDesarrolla = $objControlDesarrolla->listar();

$boton = $_POST['bt'] ?? '';
$datos_desarrolla = []; // Inicializamos el arreglo de datos del producto

switch ($boton) {
    case 'Agregar':
        $campos = ['docente', 'proyecto', "rol", "descripcion"];

        foreach ($campos as $campo) {
            $datos_desarrolla[$campo] = $_POST[$campo] ?? '';
        }

        $objDesarrolla = new Entidad($datos_desarrolla);
        $objControlDesarrolla->guardar($objDesarrolla);

        header('Location: viewDesarrolla.php'); // Redirigimos después de guardar
        exit;

    case 'Borrar':
        if (isset($_POST['docente'])) {
            $docente = $_POST['docente']; // Obtener el docente para borrar
            $objControlDesarrolla->borrar('docente', $docente); // Llamar al método borrar con el campo 'docente'
            header('Location: viewDesarrolla.php'); // Redirigimos después de borrar
            exit;
        }

    case 'Editar':
        if (isset($_POST['docente'])) {
           
            $docente = $_POST['docente'];  // Usamos 'docente' como el identificador
            // Buscamos los datos del docente usando su identificador (docente)
            $obtenerDocente = $objControlDesarrolla->buscarPorId('docente', $docente);
            
            // Ahora llenamos el arreglo con los datos del docente
            $datos_desarrolla = [
                'docente' => $docente,  // Agregamos el campo 'docente' al arreglo
                'proyecto' => $obtenerDocente->__get('proyecto'),
                'rol' => $obtenerDocente->__get('rol'),
                'descripcion' => $obtenerDocente->__get('descripcion'),
            ];
            
        }
        break;
        // No necesitamos 'break' aquí ya que la siguiente acción es 'Actualizar'

    case 'Actualizar':
        if (isset($_POST['docente'])) {
            $docente = $_POST['docente'];  // Usamos 'docente' como identificador
            
            // Definimos los campos que se van a actualizar
            $campos = ['docente', 'proyecto', "rol", "descripcion"];

            // Inicializamos el arreglo de datos con los valores de $_POST
            foreach ($campos as $campo) {
                // Asignamos los valores de los campos del formulario
                $datos_desarrolla[$campo] = $_POST[$campo] ?? '';
            }

            // Creamos una nueva instancia de la clase Entidad con los datos a actualizar
            $objDesarrolla = new Entidad($datos_desarrolla);

            // Actualizamos el docente con el identificador 'docente'
            $objControlDesarrolla->modificar('docente', $docente, $objDesarrolla);

            // Redirigimos a la vista de Desarrolla después de actualizar
            header('Location: viewDesarrolla.php');
            exit; // Terminamos el script después de la redirección
        }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestión</title>
</head>

<body>
    <h1><ins>Desarrolla</ins></h1>

    <div class="view-buttons">
        <a href="./viewProyecto.php">Proyectos</a>
        <a href="./viewTipoProducto.php">Tipo Producto</a>
        <a href="./viewTerminoClave.php">Términos Clave</a>
    </div>

    <div class="users-form">
        <form method="POST" action="viewDesarrolla.php">
            <h2><?php echo isset($datos_desarrolla['docente']) ? 'Actualizar ' : 'Crear '; ?></h2>

            <!-- Cambiar 'id' por 'docente' -->
            <input type="hidden" name="docente" value="<?php echo $datos_desarrolla['docente'] ?? ''; ?>">

            <input type="text" name="docente" placeholder="Docente" value="<?php echo $datos_desarrolla['docente'] ?? ''; ?>" required>
            <input type="text" name="rol" placeholder="Rol" value="<?php echo $datos_desarrolla['rol'] ?? ''; ?>" required>
            <input type="text" name="descripcion" placeholder="Descripción" value="<?php echo $datos_desarrolla['descripcion'] ?? ''; ?>" required>

            <select name="proyecto" id="proyecto" required>
                <option value="">Seleccione un Proyecto</option>
                <?php foreach ($arregloListar as $proyecto): ?>
                    <option value="<?= $proyecto->__get('id') ?>" <?= (isset($datos_desarrolla['proyecto']) && $datos_desarrolla['proyecto'] == $proyecto->__get('id')) ? 'selected' : '' ?>>
                        <?= $proyecto->__get('titulo') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Cambiar el valor del botón de acuerdo a si estamos creando o actualizando -->
            <input type="submit" name="bt" value="<?php echo isset($datos_desarrolla['docente']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Desarrolla</h2>
        <table>
            <thead>
                <tr>
                    <th>Docente</th>
                    <th>Rol</th>
                    <th>Descripcion</th>
                    <th>Proyecto</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($arregloListarDesarrolla as $desarrolla): ?>
                    <tr>
                        <td><?= $desarrolla->__get('docente') ?></td>
                        <td><?= $desarrolla->__get('rol') ?></td>
                        <td><?= $desarrolla->__get('descripcion') ?></td>
                        <td><?= $desarrolla->__get('proyecto') ?></td>
                        <td>
                            <form method="POST" action="viewDesarrolla.php" style="display:inline;">
                                <!-- Usamos 'docente' como el campo oculto -->
                                <input type="hidden" name="docente" value="<?= $desarrolla->__get('docente') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                            <form method="POST" action="viewDesarrolla.php" style="display:inline;">
                                <!-- Usamos 'docente' como el campo oculto para borrar -->
                                <input type="hidden" name="docente" value="<?= $desarrolla->__get('docente') ?>">
                                <input type="submit" name="bt" value="Borrar" class="users-table--delete" onclick="return confirm('¿Está seguro de que desea borrar este registro?');">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
