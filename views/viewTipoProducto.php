<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

$objControlTipoProducto = new ControlEntidad('tipo_producto');
$arregloListar = $objControlTipoProducto->listar();

$boton = $_POST['bt'] ?? '';
$datos_TipoProducto = []; // Inicializamos el arreglo de datos del tipo de producto

switch ($boton) {
    case 'Agregar':
        $campos = ['categoria', 'clase', 'nombre', 'tipologia'];

        foreach ($campos as $campo) {
            $datos_TipoProducto[$campo] = $_POST[$campo] ?? '';
        }

        $objTipoProducto = new Entidad($datos_TipoProducto);
        $objControlTipoProducto->guardar($objTipoProducto);

        header('Location: viewTipoProducto.php');
        exit; // Agregamos exit después de redireccionar

    case 'Borrar':
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID del tipo de producto a borrar
            $objControlTipoProducto->borrar('id', $id); // Llamar al método borrar con el ID
        }
        header('Location: viewTipoProducto.php');
        exit; // Agregamos exit después de redireccionar

    case 'Editar':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $obtenerId = $objControlTipoProducto->buscarPorId('id', $id);
           
            // Ahora llenamos el arreglo de datos de los tipo de producto
            $datos_TipoProducto = [
                'id' => $id, // Agregamos el ID al arreglo
                'categoria' => $obtenerId->__get('categoria'),
                'clase' => $obtenerId->__get('clase'),
                'nombre' => $obtenerId->__get('nombre'),
                'tipologia' => $obtenerId->__get('tipologia')
            ];
        }
        break; // Cambiamos a un break aquí para que no se ejecute más código

    case 'Actualizar': // Cambiamos "Editar" a "Actualizar" para el botón del formulario
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $campos = ['categoria', 'clase', 'nombre', 'tipologia'];

            foreach ($campos as $campo) {
                $datos_TipoProducto[$campo] = $_POST[$campo] ?? '';
            }

            $objTipoProducto = new Entidad($datos_TipoProducto);
            $objControlTipoProducto->modificar('id', $id, $objTipoProducto);
        }
        header('Location: viewTipoProducto.php');
        exit; // Agregamos exit después de redireccionar
}

?>

<!DOCTYPE html>
<html lang="en">

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
        <a href="./viewTipoProducto.php">Tipo Producto</a>e
        <a href="./viewTerminoClave.php">Términos Clave</a>
    </div>

    <div class="users-form">
        <form method="POST" action="viewTipoProducto.php" >
            <h2><?php echo isset($datos_TipoProducto['id']) ? 'Actualizar Tipo Producto' : 'Crear Tipo Producto'; ?></h2>

            <!-- Se agrega un campo oculto para el ID del tipo de producto -->
            <input type="hidden" name="id" value="<?php echo $datos_TipoProducto['id'] ?? ''; ?>">

            <input type="text" name="categoria" placeholder="Categoria" value="<?php echo $datos_TipoProducto['categoria'] ?? ''; ?>" required>
            <input type="text" name="clase" placeholder="Clase" value="<?php echo $datos_TipoProducto['clase'] ?? ''; ?>" required>
            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $datos_TipoProducto['nombre'] ?? ''; ?>" required>
            <input type="text" name="tipologia" placeholder="Tipología" value="<?php echo $datos_TipoProducto['tipologia'] ?? ''; ?>" required>

            <input type="submit" name="bt" value="<?php echo isset($datos_TipoProducto['id']) ? 'Actualizar' : 'Agregar'; ?>">
 
        </form>
    </div>

    <div class="users-table">

        <h2>Tipo Producto</h2>
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Clase</th>
                    <th>Nombre</th>
                    <th>Tipologia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arregloListar as $tipoproducto): ?>
                    <tr>
                        <td> <?= $tipoproducto->__get('categoria') ?> </td>
                        <td> <?= $tipoproducto->__get('clase') ?> </td>
                        <td> <?= $tipoproducto->__get('nombre') ?> </td>
                        <td> <?= $tipoproducto->__get('tipologia') ?> </td>
                        <td>
                            <form method="POST" action="viewTipoProducto.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $tipoproducto->__get('id') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="viewTipoProducto.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $tipoproducto->__get('id') ?>">
                                <input type="submit" name="bt" value="Borrar" class="users-table--delete">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>