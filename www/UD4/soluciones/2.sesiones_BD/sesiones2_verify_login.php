<?php
/* Iniciar sesión y comprobar si el usuario es correcto mediante una función: 

- Usuarios validos: 
    Usuario 1 (para este rol es 0): 
        nombre: usuario
        contraseña: abc123.
    Usuario 2 (para este rol es 1): 
        nombre: admin
        contraseña: 1234

*/
session_start();

if(isset($_POST["usuario"]) && isset($_POST["pass"])) {
    $name= $_POST["usuario"];
    $pass= $_POST["pass"];

    $servername = 'db';
    $username = 'root';
    $password = 'test';
    $dbname = 'sesiones';

    try {
        $conPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $e) {
        echo 'Fallo en conexión: ' . $e->getMessage();
    }

    //Preparar el select 
    $stmt = $conPDO->prepare('SELECT nombre, pass, rol FROM usuario WHERE nombre= "' . $name . '"');
    $stmt->execute();

    //Recuperamos el resultado y guardamos como array asociativo
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $resultados = $stmt->fetchAll();
    $usuarios= [];
    if(count($resultados) > 0) {
        array_push($usuarios, $resultados[0]);

        if($name == $usuarios[0]["nombre"] && password_verify($pass, $usuarios[0]["pass"])) {
            $user["usuario"]= $name;
            $user["rol"]= $usuarios[0]["rol"];
            $_SESSION["usuario"]= $user;
            header("Location: index.php");
        }
    }
    else {
        header("Location: sesiones2_login.php");
    }
}
else {
    echo "Error en la verificación";
}