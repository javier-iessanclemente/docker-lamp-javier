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
    }
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="<?php echo isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD5. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('../vista/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php 
            require_once('../utils.php');
            require_once(__DIR__ . '/../modelo/Usuario.php');
            include_once('../vista/menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Borrar usuario</h2>
                </div>

                <div class="container justify-content-between">
                    <?php
                        require_once('../modelo/pdo.php');
                        if (!empty($_GET))
                        {
                            $id = $_GET['id'];
                            if (!empty($id))
                            {
                                $usuario= new Usuario();
                                $usuario->setId($id);
                                $resultado = borraUsuario($usuario);
                                if ($resultado[0])
                                {
                                    echo '<div class="alert alert-success" role="alert">Usuario borrado correctamente.</div>';
                                }
                                else
                                {
                                    echo '<div class="alert alert-danger" role="alert">No se pudo borrar el usuario.</div>';
                                }
                            }
                            else
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información del usuario.</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger" role="alert">Debes acceder a través del listado de usuarios.</div>';
                        }
                    ?>

                </div>
            </main>
        </div>
    </div>

    <?php include_once('../vista/footer.php'); ?>
    
</body>
</html>
