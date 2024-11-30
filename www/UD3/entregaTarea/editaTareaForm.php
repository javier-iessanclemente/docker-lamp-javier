<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de edición de la tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Actualizar tarea</h2>
                </div>

                <div class="container justify-content-between">
                
                    <form action="editaTarea.php" method="POST" class="mb-5 w-50">
                        <?php 
                            $id= $_GET["id"];
                            require_once("mysqli.php");
                            $resultado= obtenerTarea($id);
                            if(is_array($resultado)) {
                                foreach($resultado as $tarea) {
                                    echo '<div class="mb-3">';
                                    echo '<label for="titulo" class="form-label">Título de la tarea</label>';
                                    echo '<input type="text" class="form-control" id="titulo" name="titulo" value="' . $tarea["titulo"] . '" required/>';
                                    echo '</div>';
                                    echo '<div class="mb-3">';
                                    echo '<label for="descripcion" class="form-label">Descripción de la tarea</label>';
                                    echo '<input type="text" class="form-control" id="descripcion" name="descripcion" value="' . $tarea["descripcion"] . '" required/>';
                                    echo '</div>';
                                    echo '<div class="mb-3">';
                                    echo '<label for="estado" class="form-label">Estado de la tarea</label>';
                                    echo '<select class="form-select" id="estado" name="estado" value="' . $tarea["estado"] . '" required>';
                                    echo '<option value="pendiente" ' . (($tarea["estado"] == "pendiente") ? 'selected' : '') . '>Pendiente</option>';
                                    echo '<option value="en_proceso" ' . (($tarea["estado"] == "en_proceso") ? 'selected' : '') .  '>En proceso</option>';
                                    echo '<option value="completada"' . (($tarea["estado"] == "completada") ? 'selected' : '') . '>Completada</option>';
                                    echo '</select>';
                                    echo '</div>';
                                    echo '<div class="mb-3">';
                                    echo '<label for="username" class="form-label">Usuario asociado a la tarea</label>';
                                    echo '<select name="username" class="form-select" id="username" name="username" placeholder="Nombre del usuario asociado" required>';
                                    
                                    if(!is_string(obtenerNombresUsuario(null))) {
                                        $nombres= obtenerNombresUsuario(null);
                                    }
                                    else {
                                        $nombres= [];
                                    }

                                    if(!is_string(obtenerNombresUsuario($tarea['id_usuario']))) {
                                        $username= obtenerNombresUsuario($tarea['id_usuario']);
                                    }
                                    else {
                                        $username= '';
                                    }
                                    
                                    // Bucle que crea las opciones para los diferentes usuarios: 
                                    foreach($nombres as $nombre) {
                                        if($nombre['username'] == $username[0]['username']) {
                                            echo '<option value="' . $nombre['username'] . '" selected>' . $nombre['username'] . '</option>';
                                        }
                                        else {
                                            echo '<option value="' . $nombre['username'] . '">' . $nombre['username'] . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    echo '</div>';
                                    echo '<input type="hidden" name="id" value="' . $id . '"/>';
                                    echo '<button type="submit" class="btn btn-primary">Actualizar tarea</button>';
                                }
                            }
                            if(is_string($resultado)) {
                                echo '<div class="alert alert-danger" role="alert">';
                                echo 'Fallo en el obtención de la información de la tarea: ' . $resultado;
                                echo '</div>';
                            }
                        ?>
                    </form>
                    <?php 
                        if(is_string(obtenerNombresUsuario(null))) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Fallo en la obtención de los usuarios del formulario: ' . obtenerNombresUsuario(null);
                            echo '</div>';
                        }
                        if(is_string(obtenerNombresUsuario(null))) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Fallo en el obtención del usuario de la tarea: ' . obtenerNombresUsuario(null);
                            echo '</div>';
                        }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>