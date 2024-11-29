<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD2. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    include("header.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php 
            include("menu.php");
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Gestión de tarea</h2>
                </div>
                <div class="container">
                <?php 
                    require_once('mysqli.php');
                    $titulo= $_POST['titulo'];
                    $descripcion= $_POST['descripcion'];
                    $estado= $_POST['estado'];
                    $username= $_POST['username'];

                    $resultado= registrarTarea($titulo, $descripcion, $estado, $username);
                    
                    // Estructura if-else que comprueba si algún campo no era valido, si hubo otro tipo de error o si todo fue correctamente: 
                    if(is_array($resultado)) {
                        foreach($resultado as $campo) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Registro fallido: Campo ' . $campo . ' tiene un valor no valido.';
                            echo '</div>';
                        }
                    }
                    else {
                        if(is_string($resultado)) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo $resultado;
                            echo '</div>';
                        }

                        else {
                            echo '<div class="alert alert-success" role="alert">';
                            echo 'Tarea añadida correctamente';
                            echo '</div>';
                        }
                    }
                ?>
                </div>
            </main>
        </div>
    </div>
    <?php 
    include("footer.php");
    ?>
</body>
</html>