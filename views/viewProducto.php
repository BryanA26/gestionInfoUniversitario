<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

session_start();
$rol = $_SESSION['rol'];


$objControlProyecto = new ControlEntidad('proyecto');
$arregloListar = $objControlProyecto->listar();

$objControlTipoProducto = new ControlEntidad('tipo_producto');
$arregloListarTipoProducto = $objControlTipoProducto->listar();

$objControlProducto = new ControlEntidad('producto');
$arregloListarProducto = $objControlProducto->listar();

$boton = $_POST['bt'] ?? '';
$datos_producto = []; // Inicializamos el arreglo de datos del producto

switch ($boton) {
    case 'Agregar':
        $campos = ['nombre', 'categoria', "fecha_entrega", "proyecto", "tipo_producto"];

        foreach ($campos as $campo) {
            $datos_producto[$campo] = $_POST[$campo] ?? '';
        }

        $objProducto = new Entidad($datos_producto);
        $objControlProducto->guardar($objProducto);
        header('Location: viewProducto.php'); // Redirigimos después de guardar
        exit;

    case 'Borrar':
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID del producto a borrar
            $objControlProducto->borrar('id', $id); // Llamar al método borrar con el ID
            header('Location: viewProducto.php'); // Redirigimos después de borrar
            exit;
        }

    case 'Editar':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $obtenerId = $objControlProducto->buscarPorId('id', $id);

            // Ahora llenamos el arreglo de datos del producto
            $datos_producto = [
                'id' => $id, // Agregamos el ID al arreglo
                'nombre' => $obtenerId->__get('nombre'),
                'categoria' => $obtenerId->__get('categoria'),
                'fecha_entrega' => $obtenerId->__get('fecha_entrega'),
                'proyecto' => $obtenerId->__get('proyecto'),
                'tipo_producto' => $obtenerId->__get('tipo_producto'),
            ];
        }
        break; // Cambiamos a un break aquí para que no se ejecute más código

    case 'Actualizar':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $campos = ['nombre', 'categoria', 'fecha_entrega', 'proyecto', 'tipo_producto'];

            foreach ($campos as $campo) {
                $datos_producto[$campo] = $_POST[$campo] ?? '';
            }

            $objProducto = new Entidad($datos_producto);
            $objControlProducto->modificar('id', $id, $objProducto);
            header('Location: viewProducto.php'); // Redirigimos después de actualizar
            exit;
        }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestión de Productos</title>
</head>

<body>
    <h1><ins>Gestión de Productos</ins></h1>

    
    <div class="users-form">
        <form method="POST" action="#">
            <h2><?php echo isset($datos_producto['id']) ? 'Actualizar Producto' : 'Crear Producto'; ?></h2>

            <input type="hidden" name="id" value="<?php echo $datos_producto['id'] ?? ''; ?>">

            <input type="text" name="nombre" placeholder="Nombre del producto" value="<?php echo $datos_producto['nombre'] ?? ''; ?>" required>
            <input type="text" name="categoria" placeholder="Categoría del producto" value="<?php echo $datos_producto['categoria'] ?? ''; ?>" required>
            <input type="date" name="fecha_entrega" placeholder="Fecha de entrega" value="<?php echo $datos_producto['fecha_entrega'] ?? ''; ?>" required>

            <select name="proyecto" id="proyecto" required>
                <option value="">Seleccione un Proyecto</option>
                <?php foreach ($arregloListar as $proyecto): ?>
                    <option value="<?= $proyecto->__get('id') ?>" <?= (isset($datos_producto['proyecto']) && $datos_producto['proyecto'] == $proyecto->__get('id')) ? 'selected' : '' ?>>
                        <?= $proyecto->__get('titulo') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="tipo_producto" id="tipo_producto" required>
                <option value="">Seleccione un Tipo de Producto</option>
                <?php foreach ($arregloListarTipoProducto as $tipo_producto): ?>
                    <option value="<?= $tipo_producto->__get('id') ?>" <?= (isset($datos_producto['tipo_producto']) && $datos_producto['tipo_producto'] == $tipo_producto->__get('id')) ? 'selected' : '' ?>>
                        <?= $tipo_producto->__get('categoria') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="bt" value="<?php echo isset($datos_producto['id']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Productos Creados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Fecha Entrega</th>
                    <th>Proyecto</th>
                    <th>Tipo Producto</th>
                    <?php if ($rol == 'Administrador'): ?> <!-- Solo muestra la columna "Acciones" si el rol no es estudiante -->
                    <th>Acciones</th>
                <?php endif; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($arregloListarProducto as $producto): ?>
                    <tr>
                        <td><?= $producto->__get('nombre') ?></td>
                        <td><?= $producto->__get('categoria') ?></td>
                        <td><?= $producto->__get('fecha_entrega') ?></td>
                        <td><?= $producto->__get('proyecto') ?></td>
                        <td><?= $producto->__get('tipo_producto') ?></td>
                        <td>
                        <?php if ($rol == 'Administrador'): ?>
                            <form method="POST" action="viewProducto.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $producto->__get('id') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                            <form method="POST" action="viewProducto.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $producto->__get('id') ?>">
                                <input type="submit" name="bt" value="Borrar" class="users-table--delete" onclick="return confirm('¿Está seguro de que desea borrar este producto?');">
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
