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
        if(!esAdmin()) {
            header("Location: ../index.php?redirigido=true");
        }
        else {
            require_once('../utils.php');
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $username = $_POST['username'];
            $contrasena = $_POST['contrasena'];
            $rol = $_POST['rol']; 
            $_SESSION['error']= false;
            //verificar nombre
            if (!validarCampoTexto($nombre))
            {
                $_SESSION['error'] = true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.');
            }
            //verificar apellidos
            if (!validarCampoTexto($apellidos))
            {
                $_SESSION['error'] = true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'El campo apellidos es obligatorio y debe contener al menos 3 caracteres.');
            }
            //verificar username
            if (!validarCampoTexto($username))
            {
                $_SESSION['error'] = true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'El campo username es obligatorio y debe contener al menos 3 caracteres.');
            }
            //verificar contrasena
            if (!empty($contrasena) && !validaContrasena($contrasena))
            {
                $_SESSION['error'] = true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'La contraseña debe ser compleja.');
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
                if($rol == 'normal') {
                    $rol= 0;
                }
                elseif($rol == 'administrador') {
                    $rol= 1;
                }
                require_once('../modelo/pdo.php');
                if (empty($contrasena)) $contrasena = null;
                    $resultado = actualizaUsuario($id, filtraCampo($nombre), filtraCampo($apellidos), filtraCampo($username), $contrasena, $rol);
                if ($resultado[0])
                {
                    if(!isset($_SESSION['mensajes'])) {
                        $_SESSION['mensajes']= [];
                    }
                    array_push($_SESSION['mensajes'], 'Usuario actualizado correctamente.');
                    header('Location: usuarios.php');
                }
                else
                {
                $_SESSION['error']= true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                    array_push($_SESSION['mensajes'], 'Ocurrió un error actualizando el usuario: ' . $resultado[1]);
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            }
            else {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }