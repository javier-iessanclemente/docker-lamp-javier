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
        if(isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_FILES["archivo"]) && isset($_GET["id"])) {
            require_once('../modelo/mysqli.php');
            $nombre= $_POST["nombre"];
            $descripcion= $_POST["descripcion"];
            $archivo= $_FILES["archivo"];
            $tarea_id= $_GET["id"];
            $_SESSION['error']= false;

            //verificar titulo
            if (!validarCampoTexto($nombre))
            {
                $_SESSION['error']= true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.');
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
            if (!validarArchivo($archivo)) 
            {
                $_SESSION['error']= true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'El archivo es obligatorio, debe ser un .jpg, .png o .pdf y no debe superar los 20MB de tamaño.');
            }
            if(!$_SESSION['error']) {
                $resultado= nuevoFichero($tarea_id, $nombre, $descripcion, $archivo);
                if ($resultado[0])
                {
                    if(!isset($_SESSION['mensajes'])) {
                        $_SESSION['mensajes']= [];
                    }
                    array_push($_SESSION['mensajes'], 'Fichero añadido correctamente.');
                    header('Location: ../tareas/tarea.php?id=' . $tarea_id);
                }
                else
                {  
                    $_SESSION['error']= true;
                    if(!isset($_SESSION['mensajes'])) {
                        $_SESSION['mensajes']= [];
                    }
                    array_push($_SESSION['mensajes'], 'Ocurrió un error añadiendo el fichero: ' . $resultado[1]);
                    
                }
            }
            else {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    