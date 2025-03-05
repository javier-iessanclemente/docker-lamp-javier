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
        require_once(__DIR__ . '/../modelo/Tarea.php');
        require_once(__DIR__ . '/../modelo/Usuario.php');
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
        $id_usuario = $_POST['id_usuario'];
        $_SESSION['error']= false;

        $tarea= new Tarea($titulo, $descripcion, $estado);
        $tarea->setTitulo($titulo);
        $tarea->setDescripcion($descripcion);
        $tarea->setEstado($estado);
        $usuario= new Usuario();
        if(is_numeric($id_usuario)) {
            $usuario->setId($id_usuario);
        }
        $tarea->setUsuario($usuario);
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

            $tarea= new Tarea(filtraCampo($titulo), filtraCampo($descripcion), filtraCampo($estado));
            $usuario->setId(filtraCampo($usuario->getId()));
            $tarea->setUsuario($usuario);
            $resultado = nuevaTarea($tarea);
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