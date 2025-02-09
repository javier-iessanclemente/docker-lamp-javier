<?php
     session_start();
     if(!isset($_SESSION['usuario'])) {
        $_SESSION['error']= true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'Debes iniciar sesión para acceder');
        header("Location: ../login.php?redirigido=true");
     }
    require_once('../utils.php');
    require_once('../modelo/mysqli.php');
    if(isset($_GET['id'])) {
        $id= $_GET['id'];
        $resultado= borrarFichero($id);
        if(!$resultado[0]) {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'Ocurrió un error borrando el fichero: ' . $resultado[1]);
        }
        else {
            $_SESSION['error']= false;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], $resultado[1]);
        }
        $referer= $_SERVER['HTTP_REFERER'];
        header("Location: " . $referer);
    }


    