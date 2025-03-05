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
        require_once(__DIR__ . '/../modelo/Fichero.php');
        require_once(__DIR__ . '/../modelo/Tarea.php');
        require_once(__DIR__ . '/../modelo/Usuario.php');
        require_once(__DIR__ . '/../modelo/FicherosDB.php');
        require_once(__DIR__ . '/../modelo/DatabaseException.php');
        if(isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_FILES["archivo"]) && isset($_GET["id"])) {
            require_once('../modelo/mysqli.php');
            
            $archivo= $_FILES["archivo"];
            $tarea= new Tarea();
            if(!empty($_GET['id'])) {
                $_POST['id']= $_GET['id'];
            }
            else {
                $_POST['id']= 0;
            }
            if(!empty($_FILES['archivo'])) {
                $_POST['archivo']= $archivo;
            }
            else {
                $_POST['archivo']= "";
            }
            $_SESSION['error']= false;

            //verificar
            $validacion= Fichero::validar($_POST);
            if (!empty($validacion)) {

                $_SESSION['error'] = true;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                $mensajes= $validacion;
                foreach ($mensajes as $mensaje) {
                    array_push($_SESSION['mensajes'], $mensaje);
                }
            }
            if(!$_SESSION['error']) {
                $tarea->setId($_GET['id']);
                $fichero= new Fichero($_POST['nombre'], $_POST['descripcion'], $tarea, $_FILES['archivo']);
                $fichero->setTarea($tarea);
                $tarea_id= $fichero->getTarea()->getId();
                try {
                    $ficherosDB= new FicherosDBImp();
                    $resultado= $ficherosDB->nuevoFichero($fichero);
                    if ($resultado)
                    {
                        if(!isset($_SESSION['mensajes'])) {
                            $_SESSION['mensajes']= [];
                        }
                        array_push($_SESSION['mensajes'], 'Fichero añadido correctamente.');
                        header('Location: ../tareas/tarea.php?id=' . $tarea_id);
                    }
                }
                catch(DatabaseException $e) {
                    $_SESSION['error']= true;
                    if(!isset($_SESSION['mensajes'])) {
                        $_SESSION['mensajes']= [];
                    }
                    array_push($_SESSION['mensajes'], 'Ocurrió un error añadiendo el fichero: ' . $e->getMessage());
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            }
            else {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    