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
        <form action="insert.php" method="POST">
            <h2>Crear nuevo tipo de producto</h2>

            <input type="text" name="categoria" placeholder="Categoria ">
            <input type="text" name="clase" placeholder="Clase">
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="tipologia" placeholder="Tipología">

            <input type="submit" value="Agregar nuevo tipo de producto">
            <th><a href="Entidades/tipo_producto.php?id=<?= $row['id_tipo_producto'] ?>" class="users-table--edit">Editar</a></th>
            <th><a href="Entidades/tipo_producto.php?id=<?= $row['id_tipo_producto'] ?>" class="users-table--delete">Eliminar</a></th>
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

            <body>
                <!--<?php //while($row = mysqli_fetch_array($query)):  
                    ?>-->
                <tr>

                    <th> <?= $row['categoria'] ?> </th>
                    <th> <?= $row['clase'] ?> </th>
                    <th> <?= $row['nombre'] ?> </th>
                    <th> <?= $row['tipologia'] ?> </th>


                </tr>
                <!-- <?php // endwhile; 
                        ?>-->
            </body>
        </table>

    </div>
</body>