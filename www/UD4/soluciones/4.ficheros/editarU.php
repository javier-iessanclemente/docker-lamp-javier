<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de los usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
        require_once("bdaccess.php");
        $id= $_GET["id"];
        $nombre= $_POST["nombre"];
        $apellidos= $_POST["apellidos"];
        $edad= $_POST["edad"];
        $provincia= $_POST["provincia"];
        $cambios= [$nombre, $apellidos, $edad, $provincia];
        editarUsuario($id, $cambios);
        include("footer.php");
    ?>
</body>
</html>