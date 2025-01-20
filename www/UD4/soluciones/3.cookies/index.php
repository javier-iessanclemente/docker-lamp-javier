<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD3 1.Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <?php
                        if(isset($_COOKIE["idioma"])) {
                            $idioma= $_COOKIE["idioma"];
                            switch ($idioma) {
                                case 'es':
                                    echo '<h2>Bienvenido a mi página!</h2>';
                                    break;
                                case 'en':
                                    echo '<h2>Welcome to my web page!</h2>';
                                    break;

                                case 'gl':
                                    echo '<h2>Benvido a miña páxina!</h2>';
                                    break;
                                
                                default:
                                    echo '<h2>Idioma desconocido</h2>';
                                    break;
                            }
                        }
                        else {
                            echo '<h2>Bienvenido a mi página!</h2>';
                        }
                    ?>
                </div>
                <div class="container">
                    <?php 
                    require_once("bdaccess.php");
                        try {
                            $conexion= new mysqli("db", "root", "test");
                            $sql="CREATE DATABASE IF NOT EXISTS tienda;";
                            $conexion->query($sql);
                        }
                        catch(mysqli_sql_exception $e) {
                            echo 'Error creado la BD: ' . $e->getMessage() . '<br>';
                        }
                        finally {
                            desconectar($conexion);
                        }
                        try {
                            $conexion= new mysqli("db", "root", "test", "tienda");
                            $sql="CREATE TABLE IF NOT EXISTS usuarios(
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            nombre VARCHAR(50),
                            apellidos VARCHAR(100),
                            edad INT,
                            provincia VARCHAR(50)
                            );";
                            $conexion->query($sql);
                        }
                        catch(mysqli_sql_exception $e) {
                            echo 'Error creado la tabla: ' . $e->getMessage() . '<br>';
                        }
                        finally {
                            desconectar($conexion);
                        }
                        $resultados= seleccionarUsuarios();
                        if(is_array($resultados)) {
                            echo '<table class="table table-bordered">'; 
                            echo '<thead class="table-dark">'; 
                            echo '<tr>'; 
                            echo '<th>Id</th>'; 
                            echo '<th>Nombre</th>'; 
                            echo '<th>Apellidos</th>'; 
                            echo '<th>Edad</th>'; 
                            echo '<th>Provincia</th>'; 
                            echo '<th>Acciones</th>'; 
                            echo '</tr>'; 
                            echo '</thead>'; 
                            echo '<tbody>'; 
                            foreach ($resultados as $row) { 
                                echo '<tr>'; 
                                echo '<td>' . $row[0] . '</td>'; 
                                echo '<td>' . $row[1] . '</td>'; 
                                echo '<td>' . $row[2] . '</td>'; 
                                echo '<td>' . $row[3] . '</td>'; 
                                echo '<td>' . $row[4] . '</td>'; 
                                echo '<td>'; 
                                echo '<a href="editarUsuarioForm.php?id=' . $row[0] . '" class="btn btn-success m-2" role="button">Editar</a>'; 
                                echo '<a href="borrarUsuario.php?id=' . $row[0] . '" class="btn btn-danger" role="button">Eliminar</a>'; 
                                echo '</td>'; 
                                echo '</tr>'; 
                            } 
                                echo '</tbody>'; 
                                echo '</table>';
                        }
                        else {
                            echo $resultados;
                        }
                    ?>
                </div>
                <h2>Formulario de añadido de usuarios</h2>
                <form action="agregarUsuario.php" method="post">
                    <p>Nombre del usuario: <input type="text" name="nombre" required /></p>
                    <p>Apellidos del usuario: <input type="text" name="apellidos" required /></p>
                    <p>Edad del usuario: <input type="number" name="edad" required /></p>
                    <p>Provincia de residencia del usuario: <input type="text" name="provincia" required /></p>
                    <button class="btn btn-primary" role="button" type="submit">Añadir usuario</button>
                </form>
                <br/>
                <a class="btn btn-secondary" role="button" href="cambiarIdiomaForm.php">Cambiar idioma</a>
            </main>
            <?php
            include("footer.php");
            ?>
        </div>
    </div>
</body>
</html>