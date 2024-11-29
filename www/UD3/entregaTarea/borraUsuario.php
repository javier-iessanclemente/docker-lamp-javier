<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrando usuario...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Borrar usuario</h2>
                </div>

                <div class="container justify-content-between">
                    <?php 
                        require_once("pdo.php");
                        $id= $_GET["id"];
                        $resultado= borrarUsuario($id);

                        // Estuctura If-else que compreba si el usuario se borro correctamente o hubo un error y devuelve el resultado: 
                        if(is_string($resultado)) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Fallo en el borrado del usuario: ' . $resultado;
                            echo '</div>';
                        } 
                        else {
                            echo '<div class="alert alert-success" role="alert">';
                            echo 'Usuario borrado correctamente';
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