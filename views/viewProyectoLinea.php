<?php
require_once __DIR__ . "/../connection/configBd.php";
require_once __DIR__ . "/../controllers/ControlConexionPdo.php";
require_once __DIR__ . "/../controllers/ControlEntidad.php";
require_once __DIR__ . "/../models/EntityModel.php";

$objControlProyecto = new ControlEntidad('proyecto');
$arregloListar = $objControlProyecto->listar();

$objControlProyectoLinea = new ControlEntidad('proyecto_linea');
$arregloListarProyectoLinea = $objControlProyectoLinea->listar();

$boton = $_POST['bt'] ?? '';
$datos_proyectoLinea = []; // Inicializamos el arreglo con los datos 

$arregloListarLInvestigacion = [
    "Basica",
    "Aplicada",
    "Documental",
    "Campo",
    "Experimental",
    "Descriptiva"
];

switch ($boton) {
    case 'Agregar':
        $campos = ["proyecto", "linea_investigacion"];

        foreach ($campos as $campo) {
            $datos_proyectoLinea[$campo] = $_POST[$campo] ?? '';
        }


        $objProyectoLinea = new Entidad($datos_proyectoLinea);
        $objControlProyectoLinea->guardar($objProyectoLinea);
        

        header('Location: viewProyectoLinea.php');
        exit;
        

    case 'Borrar':
        if (isset($_POST['proyecto'])) {
            $id = $_POST['proyecto']; // Obtener el ID del producto a borrar
            $objControlProyectoLinea->borrar('proyecto', $id); // Llamar al método borrar con el ID
            header('Location: viewProyectoLinea.php'); // Redirigimos después de borrar
            exit;
        }

    case 'Editar':
        if (isset($_POST['proyecto'])) {
            $id = $_POST['proyecto'];
            $obtenerId = $objControlProyectoLinea->buscarPorId('proyecto', $id);

            // Ahora llenamos el arreglo de datos del producto
            $datos_proyectoLinea = [
                'proyecto' => $id, // Agregamos el ID al arreglo
                'proyecto' => $obtenerId->__get('proyecto'),
                'linea_investigacion' => $obtenerId->__get('linea_investigacion'),
            ];
        }
        break; // Cambiamos a un break aquí para que no se ejecute más código

    case 'Actualizar':
        if (isset($_POST['proyecto'])) {
            $id = $_POST['proyecto'];
            $campos = ['proyecto', 'linea_investigacion'];

            foreach ($campos as $campo) {
                $datos_proyectoLinea[$campo] = $_POST[$campo] ?? '';
            }

            $objProyectoLinea = new Entidad($datos_proyectoLinea);
            $objControlProyectoLinea->modificar('proyecto', $id, $objProyectoLinea);
            header('Location: viewProyectoLinea.php'); // Redirigimos después de actualizar
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

    

    <div class="users-form">
        <form method="POST" action="#">
            <h2><?php echo isset($datos_proyectoLinea['proyecto']) ? 'Actualizar ' : 'Crear '; ?></h2>

            <input type="hidden" name="proyecto" value="<?php echo $datos_proyectoLinea['proyecto'] ?? ''; ?>">

            <input type="hidden" name="proyecto" placeholder="Nombre del proyecto" value="<?php echo $datos_proyectoLinea['proyecto'] ?? ''; ?>" required>
            <input type="hidden" name="linea_investigacion" placeholder="linea de investigación" value="<?php echo $datos_proyectoLinea['linea_investigacion'] ?? ''; ?>" required>

            <select name="proyecto" id="proyecto" required>
                <option value="">Seleccione un Proyecto</option>
                <?php foreach ($arregloListar as $proyecto): ?>
                    <option value="<?= $proyecto->__get('id') ?>" <?= (isset($datos_proyectoLinea['proyecto']) && $datos_proyectoLinea['proyecto'] == $proyecto->__get('id')) ? 'selected' : '' ?>>
                        <?= $proyecto->__get('titulo') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="linea_investigacion" id="linea_investigacion" required>
                <option value="">Seleccione una linea de investigacion</option>
                <?php foreach ($arregloListarLInvestigacion as $lineaInvestigacion): ?>
                    <option value="<?php echo htmlspecialchars($lineaInvestigacion); ?>">
                        <?php echo htmlspecialchars($lineaInvestigacion); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="bt" value="<?php echo isset($datos_proyectoLinea['proyecto']) ? 'Actualizar' : 'Agregar'; ?>">
        </form>
    </div>

    <div class="users-table">
        <h2>Linea de proyectos Creados</h2>
        <table>
            <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Linea de investigación</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($arregloListarProyectoLinea as $proyectoLinea): ?>
                    <tr>
                        <td><?= $proyectoLinea->__get('proyecto') ?></td>
                        <td><?= $proyectoLinea->__get('linea_investigacion') ?></td>
                        <td>
                            <form method="POST" action="viewProyectoLinea.php" style="display:inline;">
                                <input type="hidden" name="proyecto" value="<?= $proyectoLinea->__get('proyecto') ?>">
                                <input type="submit" name="bt" value="Editar">
                            </form>
                            <form method="POST" action="viewProyectoLinea.php" style="display:inline;">
                                <input type="hidden" name="proyecto" value="<?= $proyectoLinea->__get('proyecto') ?>">
                                <input type="submit" name="bt" value="Borrar" class="users-table--delete" onclick="return confirm('¿Está seguro de que desea borrar esta linea de proyecto?');">
                            </form>
                        </td>
                    </tr>
                    
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>