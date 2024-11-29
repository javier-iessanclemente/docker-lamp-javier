<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario búsqueda tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Buscador de tareas</h2>
                </div>

                <div class="container justify-content-between">
                    <form action="tareas.php" method="GET" class="mb-5 w-50">
                        <div class="mb-3">
                            <label for="id_usuario" class="form-label">Nombre del usuario asociado</label>
                            <select class="form-select" id="id_usuario" name="id_usuario" required>
                                <option disabled value="" selected>Seleccione el usuario</option>
                                <?php      
                                    require_once("pdo.php");
                                    $nombres= obtenerNombresUsuarioPDO();

                                    // Bucle que crea las opciones para los diferentes usuarios: 
                                    foreach($nombres as $nombre) {
                                        echo '<option value="' . obtenerIdUsuarioPDO($nombre['username'])['id']. '">' . $nombre['username'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" class="form-select" id="estado" name="estado">
                                <option value="" disabled selected>Seleccione el estado</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="en_proceso">En proceso</option>
                                <option value="completada">Completada</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>