<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario nuevos usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Nueva tarea</h2>
                </div>

                <div class="container justify-content-between">
                    <form action="nueva.php" method="POST" class="mb-5 w-50">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título de la tarea" required/>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción de la tarea" required/>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" class="form-select" id="estado" name="estado" placeholder="Estado" required>
                                <option value="pendiente">Pendiente</option>
                                <option value="en_proceso">En proceso</option>
                                <option value="completada">Completada</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre del usuario asociado</label>
                            <select name="username" class="form-select" id="username" name="username" placeholder="Nombre del usuario asociado" required>
                                <?php 
                                    require_once("mysqli.php");
                                    if(!is_string(obtenerNombresUsuario(null))) {
                                        $nombres= obtenerNombresUsuario(null);
                                    }
                                    else {
                                        $nombres= [];
                                    }
                                    // Bucle que crea las opciones para los diferentes usuarios: 
                                    foreach($nombres as $nombre) {
                                        echo '<option value="' . $nombre['username'] . '">' . $nombre['username'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                    <?php 
                        if(is_string(obtenerNombresUsuario(null))) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Fallo en la obtención de los usuarios del formulario: ' . obtenerNombresUsuario(null);
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