<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba</title>
</head>
<body>
    <?php 
    include("mensaje.php");
    echo $mensaje . " ";
    cambiarMensaje();
    echo $mensaje;
    ?>
</body>
</html>