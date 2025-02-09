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
    else {
        require_once('../utils.php');
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
        $id_usuario = $_POST['id_usuario'];
        $_SESSION['error']= false;
        //verificar titulo
        if (!validarCampoTexto($titulo))
        {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'El campo titulo es obligatorio y debe contener al menos 3 caracteres.');
        }
        //verificar descripcion
        if (!validarCampoTexto($descripcion))
        {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'El campo descripcion es obligatorio y debe contener al menos 3 caracteres.');
        }
        //verificar estado
        if (!validarCampoTexto($estado))
        {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'El campo estado es obligatorio.');
        }
        //verificar id_usuario
        if (!esNumeroValido($id_usuario))
        {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'El campo usuario es obligatorio.');
        }
        if (!$_SESSION['error'])
        {
            require_once('../modelo/mysqli.php');
            $resultado = nuevaTarea(filtraCampo($titulo), filtraCampo($descripcion), filtraCampo($estado), filtraCampo($id_usuario));
            if ($resultado[0])
            {
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'Tarea guardada correctamente.');   
            }
            else
            {
                $_SESSION['error']= true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'Ocurrió un error guardando la tarea: ' . $resultado[1]);
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }