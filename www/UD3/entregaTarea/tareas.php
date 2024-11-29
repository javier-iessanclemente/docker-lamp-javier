<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    include_once("header.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php 
            include_once("menu.php");
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Tareas</h2>
                </div>
                <div class="container">
                    <div class="table">
                        <table class="table table-sm table-striped table-hover">
                            <thead class="thead">
                                <tr>                            
                                    <th>ID</th>
                                    <th>Titulo</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                require_once("mysqli.php");
                                require_once("pdo.php");
                                $busqueda= false;
                                
                                //Comprobación de si el id del un usuario a sido pasado para decidir si el acceso a tareas es una búsqueda o no: 
                                if(array_key_exists("id_usuario", $_GET)) {
                                    $busqueda= true;
                                }
                                
                                if(!$busqueda) {
                                    $resultados= mostrarTareas();
                                }
                                else {
                                    $id_usuario= $_GET["id_usuario"];
                                    $estado= '';

                                    // Comprobación de si se ha pasado un estado en la busqueda de tareas para asignarlo en caso si: 
                                    if(array_key_exists("estado", $_GET)) {
                                        $estado= $_GET["estado"];
                                    }
                                    $resultados= buscarTareas($id_usuario, $estado);
                                }
                                // Comprobación de si no hay ninguna tarea: 
                                if(is_array($resultados) && count($resultados) == 0) {
                                    echo '<tr>';
                                    echo '<td>No hay tareas</td>';
                                    echo '<td></td>';
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
                                        echo '<td>' . $fila["titulo"] .'</td>';
                                        echo '<td>' . $fila["descripcion"] .'</td>';
                                        if($fila["estado"] == 'pendiente') {
                                            echo '<td>Pendiente</td>';
                                        }
                                        elseif ($fila["estado"] == 'en_proceso'){
                                            echo '<td>En proceso</td>';
                                        } elseif ($fila["estado"] == 'completada') {
                                            echo '<td>Completada</td>';
                                        }
    
                                        echo '<td>' . obtenerNombreUsuario($fila["id_usuario"])[0]['username'] .'</td>';
                                        echo '<td><a href="editaTareaForm.php?id=' . $fila["id"] .'" role="button" class="btn btn-outline-success m-1" onclick=()>Editar</a><a href="borraTarea.php?id=' . $fila["id"] . '" role="button" class="btn btn-outline-danger m-1">Borrar</a></td>';
                                        echo '</tr>';
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                        <?php
                            // If que comprueba si se ha devuleto un error (el mensaje es un string): 
                            if(is_string($resultados)) {
                                echo '<div role="alert" class="alert alert-danger">Fallo en la muestra de las tareas: ' . $resultados . '</div>';
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