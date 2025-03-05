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
        require_once(__DIR__ . '/../modelo/Usuario.php');
        if(!esAdmin()) {
            header("Location: ../index.php?redirigido=true");
        } 
        else {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $username = $_POST['username'];
            $contrasena = $_POST['contrasena'];
            $rol= $_POST['rol'];

            $usuario= new Usuario($nombre, $apellidos, $username, $contrasena);

            $_SESSION['error']= false;
            
            //verificar campos de texto
            $validacion= $usuario->validarTextoNuevo();
            
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

            //verificar rol
            if (!validaRol($rol)) {
                $_SESSION['error']= true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'El campo rol no tiene valor o tiene un valor incorrecto.');
            }
            if (!$_SESSION['error'])
            {
                require_once('../modelo/pdo.php');
                if($rol == "normal") {
                    $rol= 0;
                }
                elseif($rol == "administrador") {
                    $rol= 1;
                }
                $usuario= new Usuario(filtraCampo($nombre), filtraCampo($apellidos), filtraCampo($username), $contrasena);
                $usuario->setRol($rol);
                $resultado = nuevoUsuario($usuario);
                if ($resultado[0])
                {
                    if(!isset($_SESSION['mensajes'])) {
                        $_SESSION['mensajes']= [];
                    }
                    array_push($_SESSION['mensajes'], 'Usuario guardado correctamente.');
                }
                else
                {   
                    $_SESSION['error'] = true;
                    if(!isset($_SESSION['mensajes'])) {
                        $_SESSION['mensajes']= [];
                    }
                    array_push($_SESSION['mensajes'], 'Ocurrió un error guardando el usuario: ' . $resultado[1]);
                }
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);

        }
    }