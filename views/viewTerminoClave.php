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

    

    <div class="users-form">
        <form action="insert.php" method="POST">
            <h2>Crear Termino clave</h2>

            <input type="text" name="termino" placeholder="Termino clave en Español">
            <input type="text" name="termino_ingles" placeholder="Termino clave en Inglés">


            <input type="submit" value="Agregar nuevo termino clave">
            <th><a href="Entidades/termino_clave.php=<?= $row['termino'] ?>" class="users-table--edit">Editar</a></th>
            <th><a href="Entidades/termino_clave.php=<?= $row['termino'] ?>" class="users-table--delete">Eliminar</a></th>
        </form>
    </div>

    <div class="users-table">

        <h2>Termino clave</h2>
        <table>
            <thead>
                <tr>
                    <th>Termino clave Español</th>
                    <th>Termino clave Inglés</th>
                </tr>
            </thead>

            <body>
                <!--<?php //while($row = mysqli_fetch_array($query)):  
                    ?>-->
                <tr>

                    <th> <?= $row['termino'] ?> </th>
                    <th> <?= $row['termino_ingles'] ?> </th>

                </tr>
                <!-- <?php // endwhile; 
                        ?>-->
            </body>
        </table>

    </div>
</body>