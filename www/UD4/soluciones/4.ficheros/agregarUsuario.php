<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php 
        require_once("bdaccess.php");
        $nombre= $_POST["nombre"];
        $apellidos= $_POST["apellidos"];
        $edad= $_POST["edad"];
        $provincia= $_POST["provincia"];
        agregarUsuario($nombre, $apellidos, $edad, $provincia);
        include("footer.php");
    ?>
</body>
</html>