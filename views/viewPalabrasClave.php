<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

$objControlProyecto = new ControlEntidad('proyecto');
$arregloListar = $objControlProyecto->listar();

$objControlTerminoClave = new ControlEntidad('termino_clave');
$arregloListarTerminoClave = $objControlTerminoClave->listar();

$objControlPClave = new ControlEntidad('palabras_clave');
$arregloListarPClave = $objControlPClave->listar();

$boton = $_POST['bt'] ?? '';
$datos_PalabrasClave = []; // Inicializamos el arreglo de datos de las palabras clave

switch ($boton) {
    case 'Agregar':
        $campos = [ "proyecto", "termino_clave"];

        foreach ($campos as $campo) {
            $datos_PalabrasClave[$campo] = $_POST[$campo] ?? '';
        }

        $objPClave = new Entidad($datos_PalabrasClave);
        $objControlPClave->guardar($objPClave);
        header('Location: viewPalabrasClave.php'); // Redirigimos después de guardar
        exit;

    case 'Borrar':
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID del producto a borrar
            $objControlPClave->borrar('id', $id); // Llamar al método borrar con el ID
            header('Location: viewPalabrasClave.php'); // Redirigimos después de borrar
            exit;
        }

    case 'Editar':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $obtenerId = $objControlPClave->buscarPorId('id', $id);

            // Ahora llenamos el arreglo de datos 
            $datos_PalabrasClave = [
                'id' => $id, // Agregamos el ID al arreglo
                'proyecto' => $obtenerId->__get('proyecto'),
                'termino_clave' => $obtenerId->__get('termino_clave'),
            ];
        }
        break; // Cambiamos a un break aquí para que no se ejecute más código

    case 'Actualizar':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $campos = [ 'proyecto', 'termino_clave'];

            foreach ($campos as $campo) {
                $datos_PalabrasClave[$campo] = $_POST[$campo] ?? '';
            }

            $objPClave = new Entidad($datos_PalabrasClave);
            $objControlPClave->modificar('id', $id, $objPClave);
            header('Location: viewPalabrasClave.php'); // Redirigimos después de actualizar
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
    <title>Proyecto de Aula</title>
</head>

<body>
    <h1><ins>Proyecto de Aula</ins></h1>

    <div class="view-buttons">
        <a href="./viewProyecto.php">Proyectos</a>
        <a href="./viewTipoProducto.php">Tipo Producto</a>
        <a href="./viewProducto.php">Productos</a>
        <a href="./viewProyectoLinea.php">Linea de Proyecto</a>
        <a href="./viewTerminoClave.php">Términos Clave</a>
        <a href="./viewPalabrasClave.php">Palabras Clave</a>
       
    </div>

    <div class="users-form">
        <form method="POST" action="#">
            <h2><?php echo isset($datos_PalabrasClave['id']) ? 'Actualizar Palabras Clave' : 'Crear Palabra Clave'; ?></h2>

            <input type="hidden" name="id" value="<?php echo $datos_PalabrasClave['id'] ?? ''; ?>">

            <input type="hidden" name="proyecto" placeholder="Nombre del proyecto" value="<?php echo $datos_producto['proyecto'] ?? ''; ?>" required>
            <input type="hidden" name="termino_clave" placeholder="Termino clave" value="<?php echo $datos_producto['termino_clave'] ?? ''; ?>" required>
           
            <select name="proyecto" id="proyecto" required>
                <option value="">Seleccione un Proyecto</option>
                <?php foreach ($arregloListar as $proyecto): ?>
                    <option value="<?= $proyecto->__get('id') ?>" <?= (isset($datos_PalabrasClave['proyecto']) && $datos_PalabrasClave['proyecto'] == $proyecto->__get('id')) ? 'selected' : '' ?>>
                        <?= $proyecto->__get('titulo') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="termino_clave" id="termino_clave" required>
                <option value="">Seleccione un termino clave</option>
                <?php foreach ($arregloListarTerminoClave as $termino_clave): ?>
                    <option value="<?= $termino_clave->__get('id') ?>" <?= (isset($datos_PalabrasClave['termino']) && $datos_PalabrasClave['termino'] == $tipo_producto->__get('id')) ? 'selected' : '' ?>>
                        <?= $termino_clave->__get('termino') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="bt" value="<?php echo isset($datos_PalabrasClave['id']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Productos Creados</h2>
        <table>
            <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Termino Clave</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($arregloListarPClave as $PalabrasClave): ?>
                    <tr>
                        <td><?= $producto->__get('proyecto') ?></td>
                        <td><?= $producto->__get('termino_clave') ?></td>
                        <td>
                            <form method="POST" action="viewPalasbrasClave.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $PalabrasClave->__get('id') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                            <form method="POST" action="viewPalabrasClave.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $PalabrasClave->__get('id') ?>">
                                <input type="submit" name="bt" value="Borrar" class="users-table--delete" onclick="return confirm('¿Está seguro de que desea borrar este producto?');">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>