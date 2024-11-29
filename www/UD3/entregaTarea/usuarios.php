<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de los usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include_once('menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Usuarios</h2>
                </div>
                <div class="container">
                    <div class="table">
                        <table class="table table-sm table-striped table-hover"> 
                            <thead class="thead">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Usuario</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="listaUsuario">
                            <?php 
                                include_once("pdo.php");
                                $resultados= mostrarUsuarios();

                                // Comprobación de si no hay ningun usuario: 
                                if(count($resultados) == 0) {
                                    echo '<tr>';
                                    echo '<td>No hay usuarios</td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '</tr>';
                                }
                                if(is_array($resultados)) {
                                    foreach($resultados as $fila) {
                                        echo '<tr>';
                                        echo '<td>' . $fila["id"] .'</td>';
                                        echo '<td>' . $fila["nombre"] .'</td>';
                                        echo '<td>' . $fila["apellidos"] .'</td>';
                                        echo '<td>' . $fila["username"] .'</td>';
                                        echo '<td><a href="editaUsuarioForm.php?id=' . $fila["id"] .'" role="button" class="btn btn-outline-success m-1" onclick=()>Editar</a><a href="borraUsuario.php?id=' . $fila["id"] . '" role="button" class="btn btn-outline-danger m-1">Borrar</a></td>';
                                        echo '</tr>';
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                        // If que comprueba si se ha devuleto un error (el mensaje es un string): 
                        if(is_string($resultados)) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Fallo en la muestra de los usuarios: ' . $resultados;
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
