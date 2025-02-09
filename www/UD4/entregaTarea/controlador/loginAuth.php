<?php
    session_start();
    require_once('../utils.php');
    $nombre = $_POST['username'];
    $contrasena = $_POST['contrasena'];
    $_SESSION['error'] = false;
    //verificar nombre
    if (!validarCampoTexto($nombre))
    {
        $_SESSION['error']= true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.');
    }
    //verificar contrasena
    if (!validaContrasena($contrasena))
    {
        $_SESSION['error']= true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'El campo contraseña es obligatorio y debe ser compleja.');
    }
    if (!$_SESSION['error'])
    {
        
        //Código a ejecutar la primera vez que se accede a la aplicación para poder acceder cuando la Base de Datos no ha sido creada: 
        /*
        if($nombre== "admintest" && $contrasena== "abc123..") {
            $_SESSION["usuario"]= ["username"=> $nombre, "rol"=> 1, "id"=> 0];
            header("Location: ../index.php");
        }*/
        else {
        
        require_once('../modelo/pdo.php');
        $resultado = ValidaUsuario(filtraCampo($nombre), filtraCampo($contrasena));
        if ($resultado[0])
        {
            $_SESSION["usuario"]= ["username"=> $resultado[1]["username"], "rol"=> $resultado[1]["rol"], "id"=> $resultado[1]["id"]];
            header("Location: ../index.php");
        }
        else
        {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'Ocurrió un verificando el usuario: ' . $resultado[1]);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        // Eliminar el comentario debajo de este es necesario para el funcionamiento del código del código mencionado en el comentario previo
        //}
    }
    else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>