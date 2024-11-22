<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

$objControlProducto = new ControlEntidad('producto');
$arregloListar = $objControlProducto->listar();

$objControlDocenteProd = new ControlEntidad('docente_producto');
$arregloListarDocenteProd = $objControlDocenteProd->listar();

$boton = $_POST['bt'] ?? '';
$datos_doc_prod = []; // Inicializamos el arreglo de datos del producto

switch ($boton) {
    case 'Agregar':
        $campos = ['docente', 'producto'];

        foreach ($campos as $campo) {
            $datos_doc_prod[$campo] = $_POST[$campo] ?? '';
        }

        $objDocenteProd = new Entidad($datos_doc_prod);
        $objControlDocenteProd->guardar($objDocenteProd);

        header('Location: viewDocenteProd.php');
        exit;

    case 'Borrar':
        if (isset($_POST['docente'])) {
            $docente = $_POST['docente']; // Obtener el docente para borrar
            $objControlDocenteProd->borrar('docente', $docente); // Llamar al método borrar con el campo 'docente'
            header('Location: viewDocenteProd.php'); // Redirigimos después de borrar
            exit;
        }

    case 'Editar':
        if (isset($_POST['docente'])) {
           
            $docente = $_POST['docente'];  // Usamos 'docente' como el identificador
            // Buscamos los datos del docente usando su identificador (docente)
            $obtenerDocente = $objControlDocenteProd->buscarPorId('docente', $docente);
            
            // Ahora llenamos el arreglo con los datos del docente
            $datos_doc_prod = [
                'docente' => $docente,  // Agregamos el campo 'docente' al arreglo
                'producto' => $obtenerDocente->__get('producto')
            ];
            
        }
        break;
        // No necesitamos 'break' aquí ya que la siguiente acción es 'Actualizar'

    case 'Actualizar':
        if (isset($_POST['docente'])) {
            $docente = $_POST['docente'];  // Usamos 'docente' como identificador
            
            // Definimos los campos que se van a actualizar
            $campos = ['docente', 'producto'];

            // Inicializamos el arreglo de datos con los valores de $_POST
            foreach ($campos as $campo) {
                // Asignamos los valores de los campos del formulario
                $datos_doc_prod[$campo] = $_POST[$campo] ?? '';
            }

            // Creamos una nueva instancia de la clase Entidad con los datos a actualizar
            $objDocenteProd = new Entidad($datos_doc_prod);

            // Actualizamos el docente con el identificador 'docente'
            $objControlDocenteProd->modificar('docente', $docente, $objDocenteProd);

            // Redirigimos a la vista de Desarrolla después de actualizar
            header('Location: viewDocenteProd.php');
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
    <h1><ins>Docente - Producto</ins></h1>

    <div class="view-buttons">
        <a href="./viewProyecto.php">Proyectos</a>
        <a href="./viewTipoProducto.php">Tipo Producto</a>
        <a href="./viewTerminoClave.php">Términos Clave</a>
    </div>

    <div class="users-form">
        <form method="POST" action="viewDocenteProd.php">
            <h2><?php echo isset($datos_doc_prod['docente']) ? 'Actualizar ' : 'Crear '; ?></h2>

            <!-- Cambiar 'id' por 'docente' -->
            <input type="hidden" name="docente" value="<?php echo $datos_doc_prod['docente'] ?? ''; ?>">

            <input type="text" name="docente" placeholder="Docente" value="<?php echo $datos_doc_prod['docente'] ?? ''; ?>" required>

            <select name="producto" id="producto" required>
                <option value="">Seleccione un producto</option>
                <?php foreach ($arregloListar as $producto): ?>
                    <option value="<?= $producto->__get('id') ?>" <?= (isset($datos_doc_prod['producto']) && $datos_doc_prod['producto'] == $producto->__get('id')) ? 'selected' : '' ?>>
                        <?= $producto->__get('nombre') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Cambiar el valor del botón de acuerdo a si estamos creando o actualizando -->
            <input type="submit" name="bt" value="<?php echo isset($datos_doc_prod['docente']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Docente - Producto</h2>
        <table>
            <thead>
                <tr>
                    <th>Docente</th>
                    <th>Proyecto</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($arregloListarDocenteProd as $desarrolla): ?>
                    <tr>
                        <td><?= $desarrolla->__get('docente') ?></td>
                        <td><?= $desarrolla->__get('producto') ?></td>
                        <td>
                            <form method="POST" action="viewDocenteProd.php" style="display:inline;">
                                <!-- Usamos 'docente' como el campo oculto -->
                                <input type="hidden" name="docente" value="<?= $desarrolla->__get('docente') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                            <form method="POST" action="viewDocenteProd.php" style="display:inline;">
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
