<?php
    session_start();
    if(!isset($_SESSION['usuario'])) {
        $_SESSION['error']= true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'Debes iniciar sesión para acceder');
        header("Location: login.php?redirigido=true");
    }
    
    if(isset($_POST['tema'])) {
        $tema= $_POST['tema'];
        setcookie('tema', $tema, time() + (86400 * 30), '/');
        $referer= $_SERVER['HTTP_REFERER'];
        header("Location: " . $referer);
    }