<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

$objControlProyecto = new ControlEntidad('proyecto');
$arregloListar = $objControlProyecto->listar();

$boton = $_POST['bt'] ?? '';
$datos_proyecto = []; // Inicializamos el arreglo de datos del proyecto

switch ($boton) {
    case 'Agregar':
        $campos = ['titulo', 'resumen', 'presupuesto', 'tipo_financiacion', 'tipo_fondos', 'fecha_inicio', 'fecha_fin'];

        foreach ($campos as $campo) {
            $datos_proyecto[$campo] = $_POST[$campo] ?? '';
        }

        $objProyecto = new Entidad($datos_proyecto);
        $objControlProyecto->guardar($objProyecto);

        header('Location: viewProyecto.php');
        exit; // Agregamos exit después de redireccionar

    case 'Borrar':
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID del proyecto a borrar
            $objControlProyecto->borrar('id', $id); // Llamar al método borrar con el ID
        }
        header('Location: viewProyecto.php');
        exit; // Agregamos exit después de redireccionar

    case 'Editar':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $obtenerId = $objControlProyecto->buscarPorId('id', $id);
           
            // Ahora llenamos el arreglo de datos del proyecto
            $datos_proyecto = [
                'id' => $id, // Agregamos el ID al arreglo
                'titulo' => $obtenerId->__get('titulo'),
                'resumen' => $obtenerId->__get('resumen'),
                'presupuesto' => $obtenerId->__get('presupuesto'),
                'tipo_financiacion' => $obtenerId->__get('tipo_financiacion'),
                'tipo_fondos' => $obtenerId->__get('tipo_fondos'),
                'fecha_inicio' => $obtenerId->__get('fecha_inicio'),
                'fecha_fin' => $obtenerId->__get('fecha_fin')
            ];
        }
        break; // Cambiamos a un break aquí para que no se ejecute más código

    case 'Actualizar': // Cambiamos "Editar" a "Actualizar" para el botón del formulario
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $campos = ['titulo', 'resumen', 'presupuesto', 'tipo_financiacion', 'tipo_fondos', 'fecha_inicio', 'fecha_fin'];

            foreach ($campos as $campo) {
                $datos_proyecto[$campo] = $_POST[$campo] ?? '';
            }

            $objProyecto = new Entidad($datos_proyecto);
            $objControlProyecto->modificar('id', $id, $objProyecto);
        }
        header('Location: viewProyecto.php');
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
        <a href="./viewTipoProducto.php">Tipo Producto</a>
        <a href="./viewTerminoClave.php">Términos Clave</a>
    </div>

    <div class="users-form">
        <form method="POST" action="viewProyecto.php">
            <h2><?php echo isset($datos_proyecto['id']) ? 'Actualizar Proyecto' : 'Crear Proyecto'; ?></h2>

            <!-- Se agrega un campo oculto para el ID del proyecto -->
            <input type="hidden" name="id" value="<?php echo $datos_proyecto['id'] ?? ''; ?>">
            
            <input type="text" name="titulo" placeholder="Titulo proyecto" value="<?php echo $datos_proyecto['titulo'] ?? ''; ?>" required>
            <textarea name="resumen" placeholder="Breve resumen del proyecto" required><?php echo $datos_proyecto['resumen'] ?? ''; ?></textarea>
            <input type="number" name="presupuesto" placeholder="Presupuesto" max="1000000000" value="<?php echo $datos_proyecto['presupuesto'] ?? ''; ?>" required>
            <input type="text" name="tipo_financiacion" placeholder="Tipo de financiación" value="<?php echo $datos_proyecto['tipo_financiacion'] ?? ''; ?>" required>
            <input type="text" name="tipo_fondos" placeholder="Tipo de fondos" value="<?php echo $datos_proyecto['tipo_fondos'] ?? ''; ?>" required>
            <input type="date" name="fecha_inicio" placeholder="Fecha inicio del proyecto" value="<?php echo $datos_proyecto['fecha_inicio'] ?? ''; ?>" required>
            <input type="date" name="fecha_fin" placeholder="Fecha finalización del proyecto" value="<?php echo $datos_proyecto['fecha_fin'] ?? ''; ?>">

            <!-- Cambiamos el texto del botón en función de si estamos editando o creando -->
            <input type="submit" name="bt" value="<?php echo isset($datos_proyecto['id']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Proyectos creados</h2>
        <table>
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Resumen</th>
                    <th>Presupuesto</th>
                    <th>Tipo de financiación</th>
                    <th>Tipo de fondos</th>
                    <th>Fecha inicio del proyecto</th>
                    <th>Fecha finalización del proyecto</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($arregloListar as $proyecto): ?>
                    <tr>
                        <td> <?= $proyecto->__get('titulo') ?> </td>
                        <td> <?= $proyecto->__get('resumen') ?> </td>
                        <td> <?= $proyecto->__get('presupuesto') ?> </td>
                        <td> <?= $proyecto->__get('tipo_financiacion') ?> </td>
                        <td> <?= $proyecto->__get('tipo_fondos') ?> </td>
                        <td> <?= $proyecto->__get('fecha_inicio') ?> </td>
                        <td> <?= $proyecto->__get('fecha_fin') ?> </td>
                        <td>
                            <form method="POST" action="viewProyecto.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $proyecto->__get('id') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="viewProyecto.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $proyecto->__get('id') ?>">
                                <input type="submit" name="bt" value="Borrar" class="users-table--delete">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
