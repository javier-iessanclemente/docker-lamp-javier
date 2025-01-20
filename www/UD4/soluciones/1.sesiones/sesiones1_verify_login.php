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

function verificar_usuario($name, $pass) {
    if($name == 'usuario' && $pass == 'abc123.') {
        $_SESSION["usuario"]= $name;
        $_SESSION["rol"]= 0;
        return true;
    }
    elseif($name == 'admin' && $pass == '1234') {
        $_SESSION["usuario"]= $name;
        $_SESSION["rol"]= 1;
        return true;
    }
    return false;
}

if(isset($_POST["usuario"]) && isset($_POST["pass"])) {
    $name= htmlspecialchars($_POST["usuario"]);
    $pass= htmlspecialchars($_POST["pass"]);
    if(!verificar_usuario($name, $pass)) {
        session_destroy();
        header("Location: sesiones1_login.php?redirigido=true");
    }
    else {
        header("Location: index.php");
    }
}
else {
    echo "Error en la verificación";
}