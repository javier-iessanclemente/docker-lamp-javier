<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de edición del usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Actualizar usuario</h2>
                </div>

                <div class="container justify-content-between">
                
                    <form action="editaUsuario.php" method="POST" class="mb-5 w-50">
                        <?php 
                            $id= $_GET["id"];
                            include("pdo.php");
                            $resultado= mostrarUsuario($id);
                            if(is_array($resultado)) {
                                foreach($resultado as $usuario) {
                                    echo '<div class="mb-3">';
                                    echo '<label for="nombre" class="form-label">Nombre</label>';
                                    echo '<input type="text" class="form-control" id="nombre" name="nombre" value="' . $usuario["nombre"] . '" required/>';
                                    echo '</div>';
                                    echo '<div class="mb-3">';
                                    echo '<label for="apellidos" class="form-label">Apellidos</label>';
                                    echo '<input type="text" class="form-control" id="apellidos" name="apellidos" value="' . $usuario["apellidos"] . '"required/>';
                                    echo '</div>';
                                    echo '<div class="mb-3">';
                                    echo '<label for="username" class="form-label">Username</label>';
                                    echo '<input type="text" class="form-control" id="username" name="username" value="' . $usuario["username"] . '" required/>';
                                    echo '</div>';
                                    echo '<div class="mb-3">';
                                    echo '<label for="contrasena" class="form-label">Contraseña</label>';
                                    echo '<input type="password" class="form-control" id="contrasena" name="contrasena" />';
                                    echo '</div>';
                                    echo '<input type="hidden" name="id" value="' . $id . '"/>';
                                    echo '<button type="submit" class="btn btn-primary">Actualizar</button>';
                                }
                            }
                        ?>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>