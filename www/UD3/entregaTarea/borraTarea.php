<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrando tarea...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once('menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Borrar tarea</h2>
                </div>
                <div class="container justify-content-between">
                <?php 
                    require_once('mysqli.php');
                    $id= $_GET['id'];
                    $resultado= borrarTarea($id);
                    
                    // Estuctura If-else que compreba si el usuario se borro correctamente o hubo un error y devuelve el resultado: 
                    if(is_bool($resultado) && $resultado) {
                        echo '<div role="alert" class="alert alert-success">Tarea borrada correctamente</div>';
                    }
                    else {
                        echo '<div role="alert" class="alert alert-danger">Fallo en el borrado de la tarea: ' . $resultado . '</div>';
                    }
                ?>
                </div>
            </main>
        </div>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>