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
            require_once(__DIR__ . '/../modelo/Tarea.php');
            require_once(__DIR__ . '/../modelo/Usuario.php');
            include_once('../vista/menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Actualizar tarea</h2>
                    <?php
                        if(isset($_SESSION['error']) && isset($_SESSION['mensajes'])) {
                            foreach($_SESSION['mensajes'] as $mensaje) {
                                echo '<div class="'. ($_SESSION['error'] ? 'alert alert-danger' : 'alert alert-success') . '" role="alert">' . $mensaje . '</div>';
                            }
                            unset($_SESSION['error']);
                            unset($_SESSION['mensajes']);
                        }
                    }
                    ?>
                </div>

                <div class="container justify-content-between">
                    <form action="editaTarea.php" method="POST" class="mb-5 w-50">
                        <?php
                        require_once('../modelo/mysqli.php');
                        if (!empty($_GET))
                        {
                            $tarea= new Tarea();
                            if(!empty($_GET['id'])) {
                                $tarea->setId($_GET['id']);
                            }
                            else {
                                $tarea->setId(0);
                            }
                            
                            $tarea = buscaTarea($tarea);
                            if ($tarea)
                            {
                                $titulo = $tarea->getTitulo();
                                $descripcion = $tarea->getDescripcion();
                                $estado = $tarea->getEstado();
                                $usuarioTarea = $tarea->getUsuario();
                        ?>
                            <input type="hidden" name="id" value="<?php echo $tarea->getId() ?>">
                            <?php include_once('formTarea.php'); ?>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        <?php
                            }
                            else
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información de la tarea.</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger" role="alert">Debes acceder a través del listado de tareas.</div>';
                        }
                        ?>
                    </form>

                </div>
            </main>
        </div>
    </div>

    <?php include_once('../vista/footer.php'); ?>
    
</body>
</html>
