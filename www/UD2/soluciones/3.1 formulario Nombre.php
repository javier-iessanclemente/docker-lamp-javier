<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado formulario nombre</title>
</head>
<body>
    <ul>
    <?php 
    $nombre= $_POST["nombre"];
    $apellidos= $_POST["apellidos"];
    echo '<li> Nombre: '. $nombre . '</li>'; 
    echo '<li> Apellidos: '. $apellidos . '</li>'; 
    echo '<li> Nombre y apellidos: '. $nombre . " " . $apellidos .'</li>'; 
    echo '<li> Su nombre tiene caracteres '. strlen($nombre) . '. </li>';
    echo '<li> Los 3 primeros caracteres de tu nombre son: ' . substr($nombre, 0, 3) . '</li>';
    echo '<li> La letra A fue encontrada en sus apellidos en la posición: ' . stripos(strtoupper($apellidos), "A") . '</li>';
    echo '<li> Su nombre contiene ' . substr_count(strtoupper($nombre), "A") . ' caracteres “A”. </li>';
    echo '<li> Tu nombre en mayúsculas es: '. strtoupper($nombre) . '</li>';
    echo '<li> Sus apellidos en minusculas son: '. strtolower($apellidos) . '</li>';
    echo '<li> Su nombre y apellido en mayúsculas: '. strtoupper($nombre) . ' ' . strtoupper($apellidos) . '</li>';
    echo '<li> Tu nombre escrito al revés es: '. strrev($nombre) . '</li>';
    ?>
    </ul>
</body>
</html>

