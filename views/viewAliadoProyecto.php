<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

$objControlProducto = new ControlEntidad('proyecto');
$arregloListar = $objControlProducto->listar();

$objControlAliadoProyecto = new ControlEntidad('aliado_proyecto');
$arregloListarDocenteProd = $objControlAliadoProyecto->listar();

$boton = $_POST['bt'] ?? '';
$datos_doc_prod = []; // Inicializamos el arreglo de datos del producto

switch ($boton) {
    case 'Agregar':
        $campos = ['proyecto', 'aliado'];

        foreach ($campos as $campo) {
            $datos_doc_prod[$campo] = $_POST[$campo] ?? '';
        }

        $objAliadoProyecto = new Entidad($datos_doc_prod);
        $objControlAliadoProyecto->guardar($objAliadoProyecto);

        header('Location: viewAliadoProyecto.php');
        exit;

    case 'Borrar':
        if (isset($_POST['aliado'])) {
            $aliado = $_POST['aliado']; // Obtener el docente para borrar
            $objControlAliadoProyecto->borrar('aliado', $aliado); // Llamar al método borrar con el campo 'docente'
            header('Location: viewAliadoProyecto.php'); // Redirigimos después de borrar
            exit;
        }

    case 'Editar':
        if (isset($_POST['aliado'])) {
           
            $aliado = $_POST['aliado'];  // Usamos 'aliado' como el identificador
            // Buscamos los datos del aliado usando su identificador (aliado)
            $obtenerAliado = $objControlAliadoProyecto->buscarPorId('aliado', $aliado);
            
            // Ahora llenamos el arreglo con los datos del aliado
            $datos_doc_prod = [
                'aliado' => $aliado,  // Agregamos el campo 'aliado' al arreglo
                'proyecto' => $obtenerAliado->__get('proyecto')
            ];
            
        }
        break;
        // No necesitamos 'break' aquí ya que la siguiente acción es 'Actualizar'

    case 'Actualizar':
        if (isset($_POST['aliado'])) {
            $aliado = $_POST['aliado'];  // Usamos 'aliado' como identificador
            
            // Definimos los campos que se van a actualizar
            $campos = ['aliado', 'proyecto'];

            // Inicializamos el arreglo de datos con los valores de $_POST
            foreach ($campos as $campo) {
                // Asignamos los valores de los campos del formulario
                $datos_doc_prod[$campo] = $_POST[$campo] ?? '';
            }

            // Creamos una nueva instancia de la clase Entidad con los datos a actualizar
            $objAliadoProyecto = new Entidad($datos_doc_prod);

            // Actualizamos el docente con el identificador 'docente'
            $objControlAliadoProyecto->modificar('aliado', $aliado, $objAliadoProyecto);

            // Redirigimos a la vista de Desarrolla después de actualizar
            header('Location: viewAliadoProyecto.php');
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
    <h1><ins>Aliado - Proyecto</ins></h1>

   
    <div class="users-form">
        <form method="POST" action="viewAliadoProyecto.php">
            <h2><?php echo isset($datos_doc_prod['aliado']) ? 'Actualizar ' : 'Crear '; ?></h2>

            <!-- Cambiar 'id' por 'docente' -->
            <input type="hidden" name="aliado" value="<?php echo $datos_doc_prod['aliado'] ?? ''; ?>">

            <input type="text" name="aliado" placeholder="aliado" value="<?php echo $datos_doc_prod['aliado'] ?? ''; ?>" required>

            <select name="proyecto" id="proyecto" required>
                <option value="">Seleccione un proyecto</option>
                <?php foreach ($arregloListar as $proyecto): ?>
                    <option value="<?= $proyecto->__get('id') ?>" <?= (isset($datos_doc_prod['proyecto']) && $datos_doc_prod['proyecto'] == $proyecto->__get('id')) ? 'selected' : '' ?>>
                        <?= $proyecto->__get('titulo') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Cambiar el valor del botón de acuerdo a si estamos creando o actualizando -->
            <input type="submit" name="bt" value="<?php echo isset($datos_doc_prod['aliado']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Docente - Producto</h2>
        <table>
            <thead>
                <tr>
                    <th>Aliado</th>
                    <th>Proyecto</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($arregloListarDocenteProd as $desarrolla): ?>
                    <tr>
                        <td><?= $desarrolla->__get('aliado') ?></td>
                        <td><?= $desarrolla->__get('proyecto') ?></td>
                        <td>
                            <form method="POST" action="viewAliadoProyecto.php" style="display:inline;">
                                <!-- Usamos 'docente' como el campo oculto -->
                                <input type="hidden" name="aliado" value="<?= $desarrolla->__get('aliado') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                            <form method="POST" action="viewAliadoProyecto.php" style="display:inline;">
                                <!-- Usamos 'aliado' como el campo oculto para borrar -->
                                <input type="hidden" name="aliado" value="<?= $desarrolla->__get('aliado') ?>">
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
