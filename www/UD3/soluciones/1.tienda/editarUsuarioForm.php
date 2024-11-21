<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forumulario de edicción de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1>Formulario de añadido de usuarios</h1>
        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <?php
            $id= $_GET["id"];
            echo '<form action="editarU.php?id='. $id. '" method="post">';
            echo '<p>Nombre del usuario: <input type="text" name="nombre" /></p>';
            echo '<p>Apellidos del usuario: <input type="text" name="apellidos" /></p>';
            echo '<p>Edad del usuario: <input type="number" name="edad" /></p>';
            echo '<p>Provincia de residencia del usuario: <input type="text" name="provincia" /></p>';
            echo '<button class="btn btn-primary" role="button" type="submit">Editar usuario</button>';
            echo '</form>';
        ?>
        </div>
    </main>
    <?php
        include("footer.php");
    ?>
</body>
</html>