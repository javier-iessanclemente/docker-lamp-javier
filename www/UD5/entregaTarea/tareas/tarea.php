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
            require_once(__DIR__ . '/../modelo/Fichero.php');
            require_once(__DIR__ . '/../modelo/Tarea.php');
            require_once(__DIR__ . '/../modelo/Usuario.php');
            require_once(__DIR__ . '/../modelo/FicherosDB.php');
            require_once(__DIR__ . '/../modelo/DatabaseException.php');
            include_once('../vista/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                    require_once('../modelo/mysqli.php');
                    require_once('../modelo/pdo.php');
                    if (!empty($_GET))
                    {
                        
                        if(!empty($_GET['id'])) {
                            $id_tarea= $_GET['id'];
                        }
                        else {
                            $id_tarea= 0;
                        }
                        $tarea= new Tarea();
                        $tarea->setId($id_tarea);
                        $tarea = buscaTarea($tarea);
                        $ficherosDB= new FicherosDBImp();
                        try {
                            $resultado_ficheros= $ficherosDB->listaFicheros($id_tarea);
                        }
                        catch (DatabaseException $e){
                            $_SESSION['error']= true;
                            if(isset($_SESSION['mensajes'])) {
                                array_push($_SESSION['mensajes'], $e->getMessage());
                            }
                            else {
                                $_SESSION['mensajes']= [$e->getMessage()];
                            }
                        }
                        
                        if ($tarea)
                        {
                            $titulo = $tarea->getTitulo();
                            $descripcion = $tarea->getDescripcion();
                            $estado = $tarea->getEstado();
                            $usuarioTarea = $tarea->getUsuario();
                ?>
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Tarea</h2>
                    <?php
                        if(isset($_SESSION['error']) && isset($_SESSION['mensajes'])) {
                            foreach($_SESSION['mensajes'] as $mensaje) {
                                echo '<div class="'. ($_SESSION['error'] ? 'alert alert-danger' : 'alert alert-success') . '" role="alert">' . $mensaje . '</div>';
                            }
                            unset($_SESSION['error']);
                            unset($_SESSION['mensajes']);
                        }
                    ?>
                </div>  
                <div class="container justify-content-between">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h2 class="card-title">Detalles</h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Titulo: <?php echo $titulo; ?></li>
                                <li class="list-group-item">Descripción: <?php echo $descripcion; ?></li>
                                <li class="list-group-item">Estado: 
                                <?php 
                                    if($estado == "completada") {
                                        echo 'Completada';
                                    }
                                
                                    elseif($estado == "en_proceso") {
                                        echo 'En proceso';
                                    }

                                    elseif($estado == "pendiente") {
                                        echo 'Pendiente';
                                    }
                                ?>
                                </li>
                                <li class="list-group-item">Usuario: <?php echo buscaUsuario($usuarioTarea)->getUsername(); ?></li>
                            </ul>
                        </div>
                        <?php
                            }
                                else
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información de la tarea.</div>';
                            }
                                if(isset($resultado_ficheros) && !empty($resultado_ficheros) && !$resultado_ficheros[0]) {
                                    echo '<div class="alert alert-danger" role="alert">Error al recuperar los ficheros de la tarea: ' . $resultado_ficheros[1] . '</div>';
                                }
                            }
                            else
                            {
                                echo '<div class="alert alert-danger" role="alert">Debes acceder a través del listado de tareas.</div>';
                            }
                        ?>
                    </div>
                    <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h2 class="card-title">Archivos Adjuntos</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                            if(isset($resultado_ficheros) && !empty($resultado_ficheros)) {
                                foreach($resultado_ficheros[1] as $fichero) {
                                    echo '<div class="card mb-2">';
                                    echo '<div class="card-body">';
                                    echo '<h2>' . $fichero->getNombre() . '</h2>';
                                    echo '<p class="fw-lighter">' . $fichero->getDescripcion() . '</p>';
                                    echo '<a class="btn btn-sm btn-outline-primary m-2" href="' . $fichero->getFile()['ruta']  . '" download="' . $fichero->getNombre() . '">Descargar</a>';
                                    echo '<a class="btn btn-sm btn-outline-danger" href="../ficheros/borraFich.php?id=' . $fichero->getId() . '">Eliminar</a>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <a class= "btn btn-primary" role="button" href="<?php echo ((!empty($_GET['id'])) ? '../ficheros/subidaFichForm.php?id=' . $_GET['id'] : '')?>">+</a>
                                </div>
                                <p class="text-center fw-lighter">Añadir nuevo archivo</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once('../vista/footer.php'); ?>
    
</body>
</html>