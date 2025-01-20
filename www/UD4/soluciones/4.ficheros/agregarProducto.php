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
        $descripcion = $_POST["descripcion"];
        $precio = $_POST["precio"];
        $unidades = $_POST["unidades"];
        $foto = $_FILES["foto"];
        agregarProducto($nombre, $descripcion, $precio, $unidades, $foto);
    ?>
</body>
</html>