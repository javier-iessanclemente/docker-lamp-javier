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
    require_once(__DIR__ . '/../modelo/Tarea.php');
    require_once(__DIR__ . '/../modelo/Usuario.php');
    $tarea= new Tarea();
    $tarea->setId($_POST['id']);
    $tarea->setTitulo(filtraCampo($_POST['titulo']));
    $tarea->setDescripcion(filtraCampo($_POST['descripcion']));
    $tarea->setEstado(filtraCampo($_POST['estado']));
    $usuario= new Usuario();
    if(is_numeric($_POST['id_usuario'])) {
        $usuario->setId($_POST['id_usuario']);
    }
    $tarea->setUsuario($usuario);

    $_SESSION['error']= false;

    //verificar
    $validacion= $tarea->validar();
    if (!$validacion[0])
    {
        $_SESSION['error'] = true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        $mensajes= $validacion[1];
        foreach ($mensajes as $mensaje) {
            array_push($_SESSION['mensajes'], $mensaje);
        }
    }
    if (!$_SESSION['error'])
    {
        require_once('../modelo/mysqli.php');
        $resultado = actualizaTarea($tarea);
        if ($resultado[0])
        {
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'Tarea actualizada correctamente.');
            header('Location: tareas.php');
        }
        else
        {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'Ocurrió un error actualizando la tarea: ' . $resultado[1]);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    else
    {
        $_SESSION['error']= true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'No se pudo recuperar la información de la tarea.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
    

