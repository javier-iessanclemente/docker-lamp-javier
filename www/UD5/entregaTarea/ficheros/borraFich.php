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
    require_once(__DIR__ . '/../modelo/Fichero.php');
    require_once(__DIR__ . '/../modelo/Tarea.php');
    require_once(__DIR__ . '/../modelo/Usuario.php');
    require_once(__DIR__ . '/../modelo/FicherosDB.php');
    require_once(__DIR__ . '/../modelo/DatabaseException.php');
    require_once('../modelo/mysqli.php');
    if(isset($_GET['id'])) {
        $fichero= new Fichero();
        $fichero->setId($_GET['id']);
        
        try {
            $ficherosDB= new FicherosDBImp();
            $resultado= $ficherosDB->borraFichero($fichero->getId());
            if($resultado) {
                $_SESSION['error']= false;
                if(!isset($_SESSION['mensajes'])) {
                    $_SESSION['mensajes']= [];
                }
                array_push($_SESSION['mensajes'], 'Fichero borrado correctamente.');
            }
        }
        catch(DatabaseException $e) {
            $_SESSION['error']= true;
            if(!isset($_SESSION['mensajes'])) {
                $_SESSION['mensajes']= [];
            }
            array_push($_SESSION['mensajes'], 'Ocurrió un error borrando el fichero: ' . $e->getMessage());
        }
        finally {
            $referer= $_SERVER['HTTP_REFERER'];
            header("Location: " . $referer);
        }
    }


    