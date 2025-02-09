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
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $id_usuario = $_POST['id_usuario'];
    $_SESSION['error']= false;
    //verificar titulo
    if (!validarCampoTexto($titulo))
    {
        $_SESSION['error'] = true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'El campo titulo es obligatorio y debe contener al menos 3 caracteres.');
    }
    //verificar descripcion
    if (!validarCampoTexto($descripcion))
    {
        $_SESSION['error'] = true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'El campo descripcion es obligatorio y debe contener al menos 3 caracteres.');
    }
    //verificar estado
    if (!validarCampoTexto($estado))
    {
        $_SESSION['error'] = true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'El campo estado es obligatorio.');
    }
    //verificar id_usuario
    if (!esNumeroValido($id_usuario))
    {
        $_SESSION['error'] = true;
        if(!isset($_SESSION['mensajes'])) {
            $_SESSION['mensajes']= [];
        }
        array_push($_SESSION['mensajes'], 'El campo usuario es obligatorio.');
    }
    if (!$_SESSION['error'])
    {
        require_once('../modelo/mysqli.php');
        $resultado = actualizaTarea($id, filtraCampo($titulo), filtraCampo($descripcion), filtraCampo($estado), $id_usuario);
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
    
    

